<?php

/*

/*
 * This file is part of the DeadPool Bot project.
 *
 * (c) OsLab <https://github.com/OsLab>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\StaticModel;

/**
 * Static model merge request status.
 *
 * @author Michael COULLERET <michael.coulleret@gmail.com>
 * @author Florent DESPIERRES <orions07@gmail.com>
 */
final class MergeRequestStatus
{
    const OPEN = 'open';

    const OPENED = 'opened';

    const CLOSED = 'closed';

    const REOPEN = 'reopen';

    const WORK_IN_PROGRESS = 'work in progress';
}