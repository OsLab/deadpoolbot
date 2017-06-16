<?php

/*
 * This file is part of the DeadPool Bot project.
 *
 * (c) OsLab <https://github.com/OsLab>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Manager;

use Gitlab\Api\Issues;
use Gitlab\Api\MergeRequests;
use Gitlab\Api\Repositories;
use Gitlab\Client;

/**
 * Gitlab Manager.
 *
 * @author Michael COULLERET <michael.coulleret@gmail.com>
 * @author Florent DESPIERRES <orions07@gmail.com>
 */
class GitlabManager
{
    /**
     * @var Client
     */
    private $client;

    /**
     * Constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return Repositories
     */
    public function getRepository($name)
    {
        return $this->client->api('repositories');
    }

    /**
     * @return MergeRequests
     */
    public function getPullRequest()
    {
        return $this->client->api('merge_requests');
    }

    /**
     * @return Issues
     */
    public function getIssues()
    {
        return $this->client->api('issues');
    }
}
