<?php

/*
 * This file is part of the DeadPool Bot project.
 *
 * (c) OsLab <https://github.com/OsLab>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Handler;

use AppBundle\Event\WebhooksEvent;
use AppBundle\Manager\GitlabManager;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * GitLast request handler.
 *
 * @author Michael COULLERET <michael.coulleret@gmail.com>
 * @author Florent DESPIERRES <orions07@gmail.com>
 */
class GitLastRequestHandler
{
    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * @var GitlabManager
     */
    private $gitlabManager;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Constructor.
     *
     * @param EventDispatcherInterface $dispatcher
     * @param GitlabManager            $gitlabManager
     * @param LoggerInterface          $logger
     */
    public function __construct(EventDispatcherInterface $dispatcher, GitlabManager $gitlabManager, LoggerInterface $logger)
    {
        $this->dispatcher = $dispatcher;
        $this->gitlabManager = $gitlabManager;
        $this->logger = $logger;
    }

    /**
     * Handle web hook.
     *
     * @param Request $request
     *
     * @return array The response data
     */
    public function handle(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $this->logger->debug($request->getContent());

        if (null === $data) {
            throw new BadRequestHttpException('Invalid JSON body!');
        }

        $event = new WebhooksEvent($data);
        $eventName = $data['object_kind'];

        $this->logger->debug(sprintf('Event dispatch: %s', $eventName));

        $this->dispatcher->dispatch('gitlab.'.$eventName, $event);

        return [
            'event' => $eventName,
        ];
    }
}
