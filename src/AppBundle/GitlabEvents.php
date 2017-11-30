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
 * @author Michael COULLERET <michael@coulleret.pro>
 * @author Florent DESPIERRES <florent@despierres.pro>
 */
final class GitlabEvents
{
    /**
     * Triggered when a new merge request is created, an existing merge request was updated/merged/closed
     * or a commit is added in the source branch.
     */
    const MERGE_REQUEST = 'gitlab.merge_request';

    /**
     * Triggered when you push to the repository except when pushing tags.
     */
    const PUSH = 'gitlab.push';

    /**
     * Comment on merge request.
     */
    const NOTE = 'gitlab.note';

    /**
     * Triggered on status change of Pipeline.
     */
    const PIPELINE = 'gitlab.pipeline';
}
