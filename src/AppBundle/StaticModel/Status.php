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
 * Static model Status.
 *
 * @author Michael COULLERET <michael.coulleret@gmail.com>
 * @author Florent DESPIERRES <orions07@gmail.com>
 */
final class Status
{
    const NEEDS_REVIEW = 'needs_review';

    const NEEDS_WORK = 'needs_work';

    const WORKS_FOR_ME = 'works_for_me';

    const REVIEWED = 'reviewed';
}
