<?php

/*
 * This file is part of the cibot project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\EventSubscriber;

use App\EventSubscriber\NoteSubscriber;
use App\GitlabEvents;
use App\Resolver\ConfigResolver;
use Gitlab\Api\MergeRequests;
use Gitlab\Api\Repositories;
use Gitlab\Client;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

/**
 * @author Michael COULLERET <michael@coulleret.pro>
 */
class NoteSubscriberTest extends TestCase
{
    private $subscribedEvents = [
        GitlabEvents::NOTE => 'onNote',
    ];

    /**
     * @var ConfigResolver
     */
    private $configResolver;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var NoteSubscriber
     */
    private $subscriber;

    public function setUp()
    {
        $client = $this->prophesize(Client::class);
        $mergeRequestsApi = $this->prophesize(MergeRequests::class);
        $this->logger = $this->prophesize(LoggerInterface::class);
        $this->configResolver = $this->prophesize(ConfigResolver::class);

        $client->repositories()->willReturn($mergeRequestsApi->reveal());

        $this->subscriber = new NoteSubscriber($client->reveal(), $this->configResolver->reveal(), $this->logger->reveal());
    }

    public function testShouldGetSubscribedEvents()
    {
        $this->assertSame(NoteSubscriber::getSubscribedEvents(), $this->subscribedEvents);
    }
}
