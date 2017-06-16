<?php

/*
 * This file is part of the DeadPool Bot project.
 *
 * (c) OsLab <https://github.com/OsLab>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle;

/**
 * Gitlab Events.
 *
 * @see https://docs.gitlab.com/ce/system_hooks/system_hooks.html
 *
 * @author Michael COULLERET <michael.coulleret@gmail.com>
 * @author Florent DESPIERRES <orions07@gmail.com>
 */
final class GitlabEvents
{
    const MERGE_REQUEST = 'gitlab.merge_request';
}
