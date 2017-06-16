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
use AppBundle\StaticModel\Status;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class PullRequestSubscriber
 *
 * @see https://docs.gitlab.com/ce/user/project/integrations/webhooks.html#merge-request-events
 *
 * @author Michael COULLERET <michael.coulleret@gmail.com>
 * @author Florent DESPIERRES <orions07@gmail.com>
 */
class PullRequestSubscriber implements EventSubscriberInterface
{
    /**
     * @var GitlabManager
     */
    private $gitlabManager;

    /**
     * Constructor.
     *
     * @param GitlabManager $gitlabManager
     */
    public function __construct(GitlabManager $gitlabManager)
    {
        $this->gitlabManager = $gitlabManager;
    }

    /**
     * @param WebhooksEvent $event
     */
    public function onMergeRequest(WebhooksEvent $event)
    {
        $data = $event->getData();

        $pullRequestNumber = $data['object_attributes']['id'];
        $newStatus = Status::NEEDS_REVIEW;

        $this->gitlabManager->getIssues()->update($pullRequestNumber, $newStatus, []);
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
