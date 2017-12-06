<?php

/*
 * This file is part of the ci-bot project.
 *
 * (c) OsLab <https://github.com/OsLab>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Handler;

use App\Chain\TransformerChain;
use App\Event\WebhooksEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * GitLast request handler.
 *
 * @author Michael COULLERET <michael@coulleret.pro>
 * @author Florent DESPIERRES <florent@despierres.pro>
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
     * @var TransformerChain
     */
    private $transformerChain;

    public function __construct(EventDispatcherInterface $dispatcher, TransformerChain $transformerChain, LoggerInterface $logger)
    {
        $this->dispatcher = $dispatcher;
        $this->logger = $logger;
        $this->transformerChain = $transformerChain;
    }

    public function handle(Request $request): array
    {
        $data = json_decode($request->getContent(), true);

        if (null === $data) {
            throw new BadRequestHttpException('Invalid JSON body!');
        }

        $eventName = $data['object_kind'];

        $transformer = $this->transformerChain->getTransformer($eventName);
        $event = new WebhooksEvent($transformer->transform($data));

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
