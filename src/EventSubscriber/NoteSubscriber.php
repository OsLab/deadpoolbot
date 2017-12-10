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

use App\Entity\Note;
use App\Event\WebhooksEvent;
use App\GitlabEvents;
use App\Resolver\ConfigResolver;
use App\StaticModel\LabelStatus;
use App\StaticModel\MergeRequestStatus;
use Gitlab\Client;
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
     * @var Client
     */
    private $client;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var ConfigResolver
     */
    private $config;

    /**
     * @param Client          $client
     * @param ConfigResolver  $config
     * @param LoggerInterface $logger
     */
    public function __construct(Client $client, ConfigResolver $config, LoggerInterface $logger)
    {
        $this->client = $client->repositories();
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
        /** @var Note $data */
        $data = $event->getData();

        $this->logger->info('onNote');

        if (false === $this->support($data)) {
            return;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function support(Note $note): bool
    {
        if ($note->getUsername() === $this->config->getConfig('bot_username')) {
            return false;
        }


        if (true === $note->isWorkInProgress() || $note->getState() !== MergeRequestStatus::OPENED) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            GitlabEvents::NOTE => 'onNote',
        ];
    }
}
