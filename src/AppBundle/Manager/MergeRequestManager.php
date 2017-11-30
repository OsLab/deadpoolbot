<?php

/*
 * This file is part of the DeadPool Bot project.
 *
 * (c) OsLab <https://github.com/OsLab>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Manager;

use AppBundle\Entity\MergeRequest;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Manager for entity MergeRequest.
 *
 * @author Michael COULLERET <michael@coulleret.pro>
 * @author Florent DESPIERRES <florent@despierres.pro>
 */
class MergeRequestManager
{
    use ModelManagerTrait;

    /**
     * Constructor class.
     *
     * @param ManagerRegistry $doctrine Instance of doctrine service.
     */
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine->getManager();
    }

    /**
     * @param string $commit
     *
     * @return MergeRequest|Object
     */
    public function findByCommit($commit)
    {
        return $this->getRepository()->findOneBy(['last_commit_id' => $commit]);
    }

    /**
     * Creates or updates a user.
     *
     * @param MergeRequest $mergeRequest The user to persist.
     * @param bool $andFlush             Whether to flush the query or not (default true).
     *
     * @return MergeRequest
     */
    public function createOrUpdate(MergeRequest $mergeRequest, $andFlush = true)
    {
        $this->getEntityManager()->merge($mergeRequest);

        if ($andFlush === true) {
            $this->getEntityManager()->flush();
        }

        return $mergeRequest;
    }

    /**
     * {@inheritdoc}
     */
    protected function getRepository()
    {
        return $this->doctrine->getRepository('AppBundle:Alert');
    }
}
