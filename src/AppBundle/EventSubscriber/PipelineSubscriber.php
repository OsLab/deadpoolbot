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
 * @see https://docs.gitlab.com/ce/user/project/integrations/webhooks.html#pipeline-events
 *
 * @author Michael COULLERET <michael.coulleret@gmail.com>
 * @author Florent DESPIERRES <orions07@gmail.com>
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
     * @see https://docs.gitlab.com/ce/user/project/integrations/webhooks.html#pipeline-events
     */
    public function onPipeline(WebhooksEvent $event)
    {
        $data = $event->getData();

        $this->logger->info('onPipeline');

        if (false === $this->support($data)) {
            return;
        }

        $mergeRequestNumber = $data['merge_request']['id'];
        $mergeRequestProject = $data['merge_request']['target_project_id'];
        $mergeRequestUsername = $data['user']['username'];

        $pipelineStatus = $data['object_attributes']['status'];

        // The number of votes is not given, we are obliged to request.
        $builds = $data['builds'];

        /** Todos */
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
