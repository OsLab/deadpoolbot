<?php
/*
 * This file is part of the cibot project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Manager;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;

/**
 * Trait ModelManagerTrait.
 *
 * @author Michael COULLERET <michael@coulleret.pro>
 * @author Florent DESPIERRES <florent@despierres.pro>
 */
trait ModelManagerTrait
{
    /**
     * @var ManagerRegistry
     */
    protected $doctrine;

    protected function getEntityManager(): ObjectManager
    {
        return $this->doctrine->getManager();
    }

    abstract protected function getRepository(): EntityRepository;
}
