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
use AppBundle\Manager\MergeRequestManager;
use AppBundle\Resolver\ConfigResolver;
use AppBundle\StaticModel\PipelineStatus;
use Gitlab\Api\MergeRequests;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Note hook subscriber.
 *
 * @see https://docs.gitlab.com/ce/user/project/integrations/webhooks.html#pipeline-events
 *
 * @author Michael COULLERET <michael@coulleret.pro>
 * @author Florent DESPIERRES <florent@despierres.pro>
 */
class PipelineSubscriber implements EventSubscriberInterface
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
     * @var MergeRequestManager
     */
    private $mergeRequestManager;

    /**
     * @param GitlabManager       $gitlabManager
     * @param MergeRequestManager $mergeRequestManager
     * @param ConfigResolver      $config
     * @param LoggerInterface     $logger
     */
    public function __construct(GitlabManager $gitlabManager, MergeRequestManager $mergeRequestManager, ConfigResolver $config, LoggerInterface $logger)
    {
        $this->gitlabManager = $gitlabManager;
        $this->logger = $logger;
        $this->config = $config;
        $this->mergeRequestManager = $mergeRequestManager;
    }

    /**
     * Comment on merge request.
     *
     * @param WebhooksEvent $event
     *
     * @see https://docs.gitlab.com/ce/user/project/integrations/webhooks.html#pipeline-events
     *
     */
    public function onPipeline(WebhooksEvent $event)
    {
        $data = $event->getData();

        $this->logger->info('onPipeline');

        if (false === $this->support($data)) {
            return;
        }

        $this->logger->info('Pipeline commint : '.$data['commit']['id']);

        $mergeRequest = $this->mergeRequestManager->findByCommit($data['commit']['id']);

        if (!$mergeRequest) {
            $this->logger->info('Merge request is #'. $mergeRequest->getObjectId());
        } else {
            $this->logger->info('Bad way ! :/');
        }

//        $mergeRequest = $this->gitlabManager->getPullRequest()->getByIid($mergeRequestProject, $data['merge_request']['iid'])[0];
//        $upVotes = $mergeRequest['upvotes'];
//        $downVotes = $mergeRequest['downvotes'];
//
//        // ***************
//        // @todo waiting https://github.com/m4tthumphrey/php-gitlab-api/pull/201
//        // ***************
//        if ($pipelineStatus === PipelineStatus::FAILED) {
//            $lastBuildId = $builds[0]['id'];
//
//            $message = sprintf('@%s, please fix the problem: %s/builds/%s#down-build-trace', $mergeRequestUsername, $projectWebUrl, $lastBuildId);
//            $this->gitlabManager->getPullRequest()->addComment($mergeRequestProject, $mergeRequestNumber, $message);
//
//            if ($upVotes > 0) {
//                $upVotes--;
//            }
//            $downVotes++;
//
//            $mergeRequest['downvotes'] = $downVotes;
//            $mergeRequest['upvotes'] = $upVotes;
//
//            $this->gitlabManager->getPullRequest()->update($mergeRequestProject, $mergeRequestNumber, $mergeRequest);
//        }
//
//        if ($pipelineStatus === PipelineStatus::SUCCESS) {
//            $message = sprintf('Wow %@s, you\'re really too strong!', $mergeRequestUsername);
//            $this->gitlabManager->getPullRequest()->addComment($mergeRequestProject, $mergeRequestNumber, $message);
//
//            if ($downVotes > 0) {
//                $downVotes--;
//            }
//            $upVotes++;
//
//            $mergeRequest['downvotes'] = $downVotes;
//            $mergeRequest['upvotes'] = $upVotes;
//
//            $this->gitlabManager->getPullRequest()->update($mergeRequestProject, $mergeRequestNumber, $mergeRequest);
//        }
    }

    /**
     * {@inheritdoc}
     */
    public function support(array $data)
    {
        if ($data['user']['username'] === $this->config->getConfig('bot_username')) {
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
            GitlabEvents::PIPELINE => 'onPipeline',
        );
    }
}
