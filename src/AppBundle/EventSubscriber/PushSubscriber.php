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
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Push hook subscriber.
 *
 * @see https://docs.gitlab.com/ce/user/project/integrations/webhooks.html#push-events
 *
 * @author Michael COULLERET <michael.coulleret@gmail.com>
 * @author Florent DESPIERRES <orions07@gmail.com>
 */
class PushSubscriber implements EventSubscriberInterface
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
     * Triggered when you push to the repository except when pushing tags.
     *
     * @param WebhooksEvent $event
     */
    public function onPush(WebhooksEvent $event)
    {
        /** @TODO */
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return array(
            GitlabEvents::PUSH => 'onPush',
        );
    }
}
