<?php

/*
 * This file is part of the ci-bot project.
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
     * @ORM\Column(type="text", name="iid")
     */
    private $iid;

    /**
     * @ORM\Column(type="integer", name="object_id")
     */
    private $objectId;

    /**
     * @ORM\Column(type="integer", name="project_id")
     */
    private $projectId;

    /**
     * @ORM\Column(type="text", name="source_branch")
     */
    private $sourceBranch;

    /**
     * @ORM\Column(type="text", name="last_commit_id")
     */
    private $lastCommitId;

    /**
     * @ORM\Column(type="text", name="url")
     */
    private $url;

    /**
     * @ORM\Column(type="text", name="title")
     */
    private $title;

    /**
     * @ORM\Column(type="text", name="username")
     */
    private $username;

    /**
     * @ORM\Column(type="text", name="description", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="text", name="assignee_id", nullable=true)
     */
    private $assigneeId;

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

    public function getIid(): string
    {
        return $this->iid;
    }

    public function setIid(string $iid): self
    {
        $this->iid = $iid;

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

    public function getSourceBranch(): string
    {
        return $this->sourceBranch;
    }

    public function setSourceBranch(string $sourceBranch): self
    {
        $this->sourceBranch = $sourceBranch;

        return $this;
    }

    public function getLastCommitId(): string
    {
        return $this->lastCommitId;
    }

    public function setLastCommitId(string $lastCommitId): self
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

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername($username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAssigneeId(): ?string
    {
        return $this->assigneeId;
    }

    public function setAssigneeId(string $assigneeId): self
    {
        $this->assigneeId = $assigneeId;

        return $this;
    }
}
