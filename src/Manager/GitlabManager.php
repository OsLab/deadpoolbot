<?php

/*
 * This file is part of the DeadPool Bot project.
 *
 * (c) OsLab <https://github.com/OsLab>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Manager;

use Gitlab\Api\MergeRequests;
use Gitlab\Api\Repositories;
use Gitlab\Client;

/**
 * Gitlab Manager.
 *
 * @author Michael COULLERET <michael@coulleret.pro>
 * @author Florent DESPIERRES <florent@despierres.pro>
 */
class GitlabManager
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return Repositories
     */
    public function getRepository(): Repositories
    {
        return $this->client->api('repositories');
    }

    /**
     * @return MergeRequests
     */
    public function getPullRequest(): MergeRequests
    {
        return $this->client->api('merge_requests');
    }
}
