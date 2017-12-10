<?php

/*
 * This file is part of the ci-bot project.
 *
 * (c) OsLab <https://github.com/OsLab>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Event Gitlab.
 *
 * @author Michael COULLERET <michael@coulleret.pro>
 * @author Florent DESPIERRES <florent@despierres.pro>
 */
class WebhooksEvent extends Event
{
    /**
     * @var Object
     */
    private $data;

    public function __construct(Object $data)
    {
        $this->data = $data;
    }

    public function getData(): Object
    {
        return $this->data;
    }
}
