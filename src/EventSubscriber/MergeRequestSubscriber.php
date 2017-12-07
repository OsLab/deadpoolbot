<?php

/*
 * This file is part of the DeadPool Bot project.
 *
 * (c) OsLab <https://github.com/OsLab>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\EventSubscriber;

use App\Entity\MergeRequest;
use App\Event\WebhooksEvent;
use App\GitlabEvents;
use App\Manager\GitlabManager;
use App\Manager\MergeRequestManager;
use App\Repository\MergeRequestRepository;
use App\Resolver\ConfigResolver;
use App\StaticModel\LabelStatus;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Merge request hook subscriber.
 *
 * @see https://docs.gitlab.com/ce/user/project/integrations/webhooks.html#merge-request-events
 *
 * @author Michael COULLERET <michael@coulleret.pro>
 * @author Florent DESPIERRES <florent@despierres.pro>
 */
class MergeRequestSubscriber implements EventSubscriberInterface
{
    /**
     * @var GitlabManager
     */
    private $gitlabManager;

    /**
     * @var MergeRequestManager
     */
    private $mergeRequestManager;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var ConfigResolver
     */
    private $config;

    /**
     * @param GitlabManager          $gitlabManager
     * @param MergeRequestRepository $mergeRequestManager
     * @param ConfigResolver         $config
     * @param LoggerInterface        $logger
     */
    public function __construct(GitlabManager $gitlabManager, MergeRequestRepository $mergeRequestManager, ConfigResolver $config, LoggerInterface $logger)
    {
        $this->gitlabManager = $gitlabManager;
        $this->logger = $logger;
        $this->config = $config;
        $this->mergeRequestManager = $mergeRequestManager;
    }

    /**
     * Triggered when a new merge request is created.
     *
     * @param WebhooksEvent $event
     *
     * @see https://docs.gitlab.com/ee/api/merge_requests.html#update-mr
     */
    public function onMergeRequest(WebhooksEvent $event)
    {
        $data = $event->getData();

        if (false === $this->support($data)) {
            return;
        }

        $mergeRequestNumber = $data['object_attributes']['id'];
        $mergeRequestProjectId = $data['object_attributes']['target_project_id'];
        $mergeRequestTitle = $data['object_attributes']['title'];

        $labels[] = LabelStatus::NEEDS_REVIEW;

        // the PR body usually indicates if this is a Bug, Feature, BC Break or Deprecation
        if (preg_match('/\[(\s*fix\s*)\]/i', $mergeRequestTitle, $matches)) {
            $labels[] = LabelStatus::BUG;
        }

        if (preg_match('/\[(\s*deprecation\s*)\]/', $mergeRequestTitle, $matches)) {
            $labels[] = LabelStatus::DEPRECATION;
        }

        if (preg_match('/\[(\s*improve\s*)\]/i', $mergeRequestTitle, $matches)) {
            $labels[] = LabelStatus::IMPROVE;
        }

        if (count($labels) === 1) {
            $labels[] = LabelStatus::FEATURE;
        }

        $params = [
            'labels' => implode(',', $labels),
            'squash' => true,
            'remove_source_branch' => true,
            'title' => $mergeRequestTitle,
            'target_branch' => $this->config->getConfig('default_branch'),
            'description' => $data['object_attributes']['description'],
            'assignee_id' => $data['object_attributes']['assignee_id'],
            'milestone_id' => null,
        ];

        $mergeRequest = (new MergeRequest())
            ->setProjectId($mergeRequestProjectId)
            ->setLastCommitId($data['object_attributes']['last_commit']['id'])
            ->setSourceBranch($data['object_attributes']['source_branch'])
            ->setObjectId($data['object_attributes']['id'])
            ->setUrl($data['object_attributes']['url'])
            ->setIid($data['object_attributes']['iid'])
        ;

//        $this->gitlabManager->getPullRequest()->update($mergeRequestProjectId, $mergeRequestNumber, $params);
        $this->mergeRequestManager->createOrUpdate($mergeRequest);
    }

    /**
     * {@inheritdoc}
     */
    public function support(array $data)
    {
        if (false === isset($data['object_kind']) && $data['object_kind'] !== 'merge_request') {
            return false;
        }

        if ($data['user']['username'] === $this->config->getConfig('bot_username')) {
            return false;
        }

//        if (MergeRequestStatus::OPEN !== $data['object_attributes']['action']) {
//            return false;
//        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            GitlabEvents::MERGE_REQUEST => 'onMergeRequest',
        );
    }
}
