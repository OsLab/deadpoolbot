<?php

/*
 * This file is part of the DeadPool Bot project.
 *
 * (c) OsLab <https://github.com/OsLab>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\EventSubscriber;

use AppBundle\Event\WebhooksEvent;
use AppBundle\GitlabEvents;
use AppBundle\Manager\GitlabManager;
use AppBundle\Resolver\ConfigResolver;
use AppBundle\StaticModel\LabelStatus;
use AppBundle\StaticModel\MergeRequestStatus;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Note hook subscriber.
 *
 * @see https://docs.gitlab.com/ce/user/project/integrations/webhooks.html#comment-on-merge-request
 *
 * @author Michael COULLERET <michael.coulleret@gmail.com>
 * @author Florent DESPIERRES <orions07@gmail.com>
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
     * Constructor.
     *
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

        if (false === $this->support($data)) {
            return;
        }

        $mergeRequestNumber = $data['merge_request']['iid'];
        $mergeRequestProject = $data['merge_request']['target_project_id'];

        // The number of votes is not given, we are obliged to request.
        $mergeRequest = $this->gitlabManager->getPullRequest()->getByIid($mergeRequestProject, $mergeRequestNumber)[0];
        $upVotes = $mergeRequest['upvotes'];
        $labels = $mergeRequest['labels'];

        if ($upVotes > 0) {
            $labels[] = LabelStatus::REVIEWED;

            $params = [
                'labels' => implode(',', $labels),
            ];

            $this->gitlabManager->getPullRequest()->update($mergeRequestProject, $data['merge_request']['id'], $params);
        }

        // The minimum number of votes required is reached
        if ($upVotes >= $this->config->getConfig('minimum_vote_up')) {
            $this->logger->info('The minimum number of votes required is reached');

            $message = sprintf('Thank you @%s', $data['user']['username']);

            $this->gitlabManager->getPullRequest()->addComment($mergeRequestProject, $data['merge_request']['id'], $message);

            if ($this->config->getConfig('auto_merge')) {
                $this->logger->info('Merge !');

                $this->gitlabManager->getPullRequest()->merge($mergeRequestProject, $mergeRequestNumber);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function support(array $data)
    {
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
    public static function getSubscribedEvents()
    {
        return array(
            GitlabEvents::NOTE => 'onNote',
        );
    }
}
