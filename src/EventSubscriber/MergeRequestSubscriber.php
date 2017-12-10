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

use App\Entity\MergeRequest;
use App\Event\WebhooksEvent;
use App\GitlabEvents;
use App\Repository\MergeRequestRepository;
use App\Resolver\ConfigResolver;
use App\StaticModel\LabelStatus;
use Doctrine\ORM\ORMException;
use Gitlab\Api\MergeRequests;
use Gitlab\Client;
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
     * @var MergeRequests
     */
    private $client;

    /**
     * @var MergeRequestRepository
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

    public function __construct(Client $client, MergeRequestRepository $mergeRequestManager, ConfigResolver $config, LoggerInterface $logger)
    {
        $this->client = $client->api('merge_requests');
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
     *
     * @throws ORMException
     */
    public function onMergeRequest(WebhooksEvent $event): void
    {
        /** @var MergeRequest $data */
        $labels = [];
        $mergeRequest = $event->getData();

        if (false === $this->support($mergeRequest)) {
            return;
        }

        $labels[] = LabelStatus::NEEDS_REVIEW;

        // the PR body usually indicates if this is a Bug, Feature, BC Break or Deprecation
        if (preg_match('/\[(\s*fix\s*)\]/i', $mergeRequest->getTitle(), $matches)) {
            $labels[] = LabelStatus::BUG;
        }

        if (preg_match('/\[(\s*deprecation\s*)\]/', $mergeRequest->getTitle(), $matches)) {
            $labels[] = LabelStatus::DEPRECATION;
        }

        if (preg_match('/\[(\s*improve\s*)\]/i', $mergeRequest->getTitle(), $matches)) {
            $labels[] = LabelStatus::IMPROVE;
        }

        if (1 === count($labels)) {
            $labels[] = LabelStatus::FEATURE;
        }

        $params = [
            'labels' => implode(',', $labels),
            'squash' => true,
            'remove_source_branch' => true,
            'title' => $mergeRequest->getTitle(),
            'target_branch' => $this->config->getConfig('default_branch'),
            'description' => $mergeRequest->getDescription(),
            'assignee_id' => $mergeRequest->getAssigneeId(),
            'milestone_id' => null,
        ];

        $this->mergeRequestManager->createOrUpdate($mergeRequest);

        if ($this->config->isPropagateOnAPI()) {
            $this->client->update($mergeRequest->getProjectId(), $mergeRequest->getObjectId(), $params);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function support(Object $mergeRequest)
    {
        if ($mergeRequest->getUsername() === $this->config->getConfig('bot_username')) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            GitlabEvents::MERGE_REQUEST => 'onMergeRequest',
        ];
    }
}
