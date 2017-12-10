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
use App\StaticModel\MergeRequestStatus;

/**
 * @author Michael COULLERET <michael@coulleret.pro>
 * @author Florent DESPIERRES <florent@despierres.pro>
 */
class Note
{
    /**
     * @var string
     */
    private $iid;

    /**
     * @var int
     */
    private $objectId;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $note;

    /**
     * @var bool
     */
    private $workInProgress = false;

    /**
     * @var string
     */
    private $state = MergeRequestStatus::OPENED;

    public function getIid(): string
    {
        return $this->iid;
    }

    public function setIid(string $iid): self
    {
        $this->iid = $iid;

        return $this;
    }

    public function getObjectId(): int
    {
        return $this->objectId;
    }

    public function setObjectId(int $objectId): self
    {
        $this->objectId = $objectId;

        return $this;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getNote(): string
    {
        return $this->note;
    }

    public function setNote(string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function isWorkInProgress(): bool
    {
        return $this->workInProgress;
    }

    public function setWorkInProgress(bool $workInProgress): self
    {
        $this->workInProgress = $workInProgress;

        return $this;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }
}
