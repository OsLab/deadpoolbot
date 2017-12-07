<?php

/*
 * This file is part of the DeadPool Bot project.
 *
 * (c) OsLab <https://github.com/OsLab>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MergeRequestRepository")
 * @ORM\Table(name="merge_request")
 *
 * @author Michael COULLERET <michael@coulleret.pro>
 * @author Florent DESPIERRES <florent@despierres.pro>
 */
class MergeRequest
{
    const NUM_ITEMS = 20;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", name="object_id")
     */
    private $objectId;

    /**
     * @ORM\Column(type="text", name="source_branch")
     */
    private $sourceBranch;

    /**
     * @ORM\Column(type="integer", name="project_id")
     */
    private $projectId;

    /**
     * @ORM\Column(type="text", name="last_commit_id")
     */
    private $lastCommitId;

    /**
     * @ORM\Column(type="text", name="url")
     */
    private $url;

    /**
     * @ORM\Column(type="text", name="iid")
     */
    private $iid;

    public function getObjectId(): int
    {
        return $this->objectId;
    }

    public function setObjectId(int $objectId): self
    {
        $this->objectId = $objectId;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getSourceBranch(): string
    {
        return $this->sourceBranch;
    }

    public function setSourceBranch(string $sourceBranch): self
    {
        $this->sourceBranch = $sourceBranch;

        return $this;
    }

    public function getProjectId(): int
    {
        return $this->projectId;
    }

    public function setProjectId(int $projectId): self
    {
        $this->projectId = $projectId;

        return $this;
    }

    public function getLastCommitId(): string
    {
        return $this->lastCommitId;
    }

    public function setLastCommitId(string $lastCommitId)
    {
        $this->lastCommitId = $lastCommitId;

        return $this;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl($url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getIid(): string
    {
        return $this->iid;
    }

    public function setIid(string $iid): self
    {
        $this->iid = $iid;

        return $this;
    }
}
