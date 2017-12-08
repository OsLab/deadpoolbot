<?php

/*
 * This file is part of the ci-bot project.
 *
 * (c) OsLab <https://github.com/OsLab>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\EventSubscriber;

use App\Event\WebhooksEvent;
use App\GitlabEvents;
use App\Manager\GitlabManager;
use App\Resolver\ConfigResolver;
use App\StaticModel\LabelStatus;
use App\StaticModel\MergeRequestStatus;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Note hook subscriber.
 *
 * @see https://docs.gitlab.com/ce/user/project/integrations/webhooks.html#comment-on-merge-request
 *
 * @author Michael COULLERET <michael@coulleret.pro>
 * @author Florent DESPIERRES <florent@despierres.pro>
 */
class NoteSubscriber implements EventSubscriberInterface
{
    /**
     * @var GitlabManager
     */
    private $gitlabManager;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var ConfigResolver
     */
    private $config;

    /**
     * @param GitlabManager   $gitlabManager
     * @param ConfigResolver  $config
     * @param LoggerInterface $logger
     */
    public function __construct(GitlabManager $gitlabManager, ConfigResolver $config, LoggerInterface $logger)
    {
        $this->gitlabManager = $gitlabManager;
        $this->logger = $logger;
        $this->config = $config;
    }

    /**
     * Comment on merge request.
     *
     * @param WebhooksEvent $event
     *
     * @see https://docs.gitlab.com/ee/api/merge_requests.html#update-mr
     */
    public function onNote(WebhooksEvent $event)
    {
        $data = $event->getData();

        $this->logger->info('onNote');

        if (false === $this->support($data)) {
            return;
        }

        $mergeRequestNumber = $data['merge_request']['id'];
        $mergeRequestProject = $data['merge_request']['target_project_id'];
        $mergeRequestUsername = $data['user']['username'];

        // The number of votes is not given, we are obliged to request.
        $mergeRequest = $this->gitlabManager->getPullRequest()->getByIid($mergeRequestProject, $data['merge_request']['iid'])[0];
        $upVotes = $mergeRequest['upvotes'];
        $labels = $mergeRequest['labels'];

        $this->logger->info('Up vote '.$upVotes);

        if ($upVotes > 0) {
            $labels[] = LabelStatus::REVIEWED;

            $params = [
                'labels' => implode(',', $labels),
            ];

            $this->gitlabManager->getPullRequest()->update($mergeRequestProject, $mergeRequestNumber, $params);
        }

        // The minimum number of votes required is reached
        if ($upVotes >= $this->config->getConfig('minimum_vote_up')) {
            $this->logger->info('The minimum number of votes required is reached');

            $message = sprintf('Thank you @%s', $mergeRequestUsername);

            $this->gitlabManager->getPullRequest()->addComment($mergeRequestProject, $mergeRequestNumber, $message);

            if ($this->config->getConfig('auto_merge')) {
                if ($this->config->getConfig('merge_must_be_approved')) {
                    /** @todo */

                    return;
                }

                $this->gitlabManager->getPullRequest()->merge($mergeRequestProject, $mergeRequestNumber);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function support(array $data): bool
    {
        if (false === isset($data['repository']['name'])) {
            return false;
        }

        if ($data['user']['username'] === $this->config->getConfig('bot_username')) {
            return false;
        }

        if ($data['user']['username'] === $this->config->getConfig('bot_username')) {
            return false;
        }

        if ($data['merge_request']['work_in_progress'] === true ||
            $data['merge_request']['state'] !== MergeRequestStatus::OPENED) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return array(
            GitlabEvents::NOTE => 'onNote',
        );
    }
}
