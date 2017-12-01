<?php

/*
 * This file is part of the DeadPool Bot project.
 *
 * (c) OsLab <https://github.com/OsLab>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Handler;

use App\Event\WebhooksEvent;
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
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param EventDispatcherInterface $dispatcher
     * @param LoggerInterface          $logger
     */
    public function __construct(EventDispatcherInterface $dispatcher, LoggerInterface $logger)
    {
        $this->dispatcher = $dispatcher;
        $this->logger = $logger;
    }

    /**
     * @param Request $request
     *
     * @return array The response data
     */
    public function handle(Request $request): array
    {
        $data = json_decode($request->getContent(), true);

        $this->logger->debug($request->getContent());

        if (null === $data) {
            throw new BadRequestHttpException('Invalid JSON body!');
        }

        $event = new WebhooksEvent($data);
        $eventName = $data['object_kind'];

        $this->logger->debug(sprintf('Event dispatch: %s', $eventName));

        try {
            $this->dispatcher->dispatch('gitlab.'.$eventName, $event);
        } catch (\Exception $exception) {
            $this->logger->critical($exception->getMessage());
        }

        return [
            'event' => $eventName,
        ];
    }
}
