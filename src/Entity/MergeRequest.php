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
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MergeRequestRepository")
 * @ORM\Table(name="merge_request")
 *
 * @author Michael COULLERET <michael@coulleret.pro>
 * @author Florent DESPIERRES <florent@despierres.pro>
 */
class MergeRequest
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", name="object_id")
     */
    private $objectId;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="source_branch")
     */
    private $sourceBranch;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", name="project_id")
     */
    private $projectId;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="last_commit_id")
     */
    private $lastCommitId;

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

    public function setSourceBranch(int $sourceBranch): self
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

    public function getLastCommitId(): int
    {
        return $this->lastCommitId;
    }

    public function setLastCommitId(int $lastCommitId)
    {
        $this->lastCommitId = $lastCommitId;

        return $this;
    }
}
