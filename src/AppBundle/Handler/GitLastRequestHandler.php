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
use Symfony\Component\HttpKernel\Exception\PreconditionFailedHttpException;

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
     * @param GitlabManager $gitlabManager
     * @param ContainerInterface $container
     * @param LoggerInterface $logger
     */
    public function __construct(EventDispatcherInterface $dispatcher, GitlabManager $gitlabManager, ContainerInterface $container, LoggerInterface $logger)
    {
        $this->dispatcher = $dispatcher;
        $this->gitlabManager = $gitlabManager;
        $this->container = $container;
        $this->logger = $logger;
    }

    /**
     * @param Request $request
     *
     * @return array The response data
     */
    public function handle(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        if (null === $data) {
            throw new BadRequestHttpException('Invalid JSON body!');
        }

        $repositoryFullName = isset($data['repository']['name']) ? $data['repository']['name'] : null;

        if (empty($repositoryFullName)) {
            throw new BadRequestHttpException('No repository name!');
        }

        $this->logger->debug(sprintf('Handling from repository %s', $repositoryFullName));

        $manager = $this->gitlabManager->getRepository($repositoryFullName);

        if (!$manager) {
            throw new PreconditionFailedHttpException(sprintf('Unsupported repository "%s".', $repositoryFullName));
        }

        $event = new WebhooksEvent($data);
        $eventName = $data['object_kind'];

        try {
            $this->dispatcher->dispatch('gitlab.'.$eventName, $event);
        } catch (\Exception $e) {
            throw new \RuntimeException(sprintf('Failed dispatching "%s" event for "%s" repository.', $repositoryFullName), 0, $e);
        }
    }
}
