<?php

/*
 * This file is part of the DeadPool Bot project.
 *
 * (c) OsLab <https://github.com/OsLab>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Repository for entity Alert.
 *
 * @author Michael COULLERET <michael.coulleret@gmail.com>
 */
class MergeRequestRepository extends EntityRepository
{
    /**
     * Find all.
     * @return array
     */
    public function findAll()
    {
        $query = $this->createQueryBuilder('mr');

        return $query->getQuery()->getResult();
    }
}
