<?php

namespace AppBundle\Repository;

/**
 * Description of RepositoryTrait
 *
 * @author Hubsine <contact@hubsine.com>
 */
trait RepositoryTrait 
{
    /**
     * Get entity Count
     * 
     * @return mixed
     */
    public function getCount()
    {
        return $this->createQueryBuilder('entity')
            ->select('COUNT(entity)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
