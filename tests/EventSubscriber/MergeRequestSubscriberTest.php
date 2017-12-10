<?php

/*
 * This file is part of the cibot project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\EventSubscriber;

use App\EventSubscriber\MergeRequestSubscriber;
use App\GitlabEvents;
use App\Repository\MergeRequestRepository;
use App\Resolver\ConfigResolver;
use Gitlab\Api\MergeRequests;
use Gitlab\Client;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Psr\Log\LoggerInterface;

/**
 * @author Michael COULLERET <michael@coulleret.pro>
 */
class MergeRequestSubscriberTest extends TestCase
{
    private $subscribedEvents = [
        GitlabEvents::MERGE_REQUEST => 'onMergeRequest',
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
     * @var MergeRequestRepository
     */
    private $mergeRequestRepository;

    /**
     * @var MergeRequestSubscriber
     */
    private $subscriber;

    public function setUp()
    {
        $client = $this->prophesize(Client::class);
        $mergeRequestsApi = $this->prophesize(MergeRequests::class);
        $this->logger = $this->prophesize(LoggerInterface::class);
        $this->mergeRequestRepository = $this->prophesize(MergeRequestRepository::class);
        $this->configResolver = $this->prophesize(ConfigResolver::class);

        $client->api(Argument::exact('merge_requests'))->willReturn($mergeRequestsApi->reveal());

        $this->subscriber = new MergeRequestSubscriber($client->reveal(), $this->mergeRequestRepository->reveal(), $this->configResolver->reveal(), $this->logger->reveal());
    }

    public function testShouldGetSubscribedEvents()
    {
        $this->assertSame(MergeRequestSubscriber::getSubscribedEvents(), $this->subscribedEvents);
    }
}
