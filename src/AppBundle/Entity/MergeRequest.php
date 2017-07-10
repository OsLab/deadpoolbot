<?php

/*
 * This file is part of the DeadPool Bot project.
 *
 * (c) OsLab <https://github.com/OsLab>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MergeRequestRepository")
 * @ORM\Table(name="merge_request")
 *
 * @author Michael COULLERET <michael.coulleret@gmail.com>
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

    /**
     * get ObjectId
     *
     * @return string
     */
    public function getObjectId()
    {
        return $this->objectId;
    }

    /**
     * Set ObjectId
     *
     * @param string $objectId
     *
     * @return self
     */
    public function setObjectId($objectId)
    {
        $this->objectId = $objectId;

        return $this;
    }

    /**
     * get Id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * get SouceBranch
     *
     * @return string
     */
    public function getSourceBranch()
    {
        return $this->sourceBranch;
    }

    /**
     * Set SourceBranch
     *
     * @param string $sourceBranch
     *
     * @return self
     */
    public function setSourceBranch($sourceBranch)
    {
        $this->sourceBranch = $sourceBranch;

        return $this;
    }

    /**
     * get ProjectId
     *
     * @return string
     */
    public function getProjectId()
    {
        return $this->projectId;
    }

    /**
     * Set ProjectId
     *
     * @param string $projectId
     *
     * @return self
     */
    public function setProjectId($projectId)
    {
        $this->projectId = $projectId;

        return $this;
    }

    /**
     * get LastCommitId
     *
     * @return string
     */
    public function getLastCommitId()
    {
        return $this->lastCommitId;
    }

    /**
     * Set LastCommitId
     *
     * @param string $lastCommitId
     *
     * @return self
     */
    public function setLastCommitId($lastCommitId)
    {
        $this->lastCommitId = $lastCommitId;

        return $this;
    }
}
