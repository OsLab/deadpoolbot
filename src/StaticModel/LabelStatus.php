<?php

/*
 * This file is part of the ci-bot project.
 *
 * (c) OsLab <https://github.com/OsLab>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\StaticModel;

/**
 * Static model labels status.
 *
 * @author Michael COULLERET <michael@coulleret.pro>
 * @author Florent DESPIERRES <florent@despierres.pro>
 */
final class LabelStatus
{
    const NEEDS_REVIEW = 'Needs review';

    const NEEDS_WORK = 'Needs work';

    const REVIEWED = 'Reviewed';

    const BUG = 'Bug';

    const FEATURE = 'Feature';

    const DEPRECATION = 'Deprecation';

    const IMPROVE = 'Improve';
}
