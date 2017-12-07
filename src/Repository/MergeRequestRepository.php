<?php

/*
 * This file is part of the DeadPool Bot project.
 *
 * (c) OsLab <https://github.com/OsLab>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repository;

use App\Entity\MergeRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

/**
 * Repository for entity Alert.
 *
 * @author Michael COULLERET <michael@coulleret.pro>
 * @author Florent DESPIERRES <florent@despierres.pro>
 */
class MergeRequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MergeRequest::class);
    }

    public function findLatest(int $page): Pagerfanta
    {
        $queryBuilder = $this->createQueryBuilder('mr');

        return $this->createPaginator($queryBuilder->getQuery(), $page);
    }

    /**
     * Creates or updates a user.
     *
     * @param MergeRequest $mergeRequest The user to persist.
     * @param bool $andFlush             Whether to flush the query or not (board true).
     *
     * @return MergeRequest
     *
     * @throws ORMException
     */
    public function createOrUpdate(MergeRequest $mergeRequest, $andFlush = true)
    {
        $this->getEntityManager()->merge($mergeRequest);

        if ($andFlush === true) {
            try {
                $this->getEntityManager()->flush();
            } catch (ORMException $exception) {
                throw $exception;
            }
        }

        return $mergeRequest;
    }

    private function createPaginator(Query $query, int $page): Pagerfanta
    {
        return (new Pagerfanta(new DoctrineORMAdapter($query)))
            ->setMaxPerPage(MergeRequest::NUM_ITEMS)
            ->setCurrentPage($page)
        ;
    }
}
