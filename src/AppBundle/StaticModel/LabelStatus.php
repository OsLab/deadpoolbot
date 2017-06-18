<?php

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
 * Static model labels status.
 *
 * @author Michael COULLERET <michael.coulleret@gmail.com>
 * @author Florent DESPIERRES <orions07@gmail.com>
 */
final class LabelStatus
{
    const NEEDS_REVIEW = 'needs review';

    const NEEDS_WORK = 'needs work';

    const REVIEWED = 'Reviewed';

    const BUG = 'Bug';

    const FEATURE = 'Feature';

    const DEPRECATION = 'Deprecation';

    const IMPROVE = 'Improve';
}
