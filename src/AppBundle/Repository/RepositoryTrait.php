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
    
    /**
     * Get with address
     * 
     * @param \AppBundle\Repository\QueryBuilder $qb
     * @return \AppBundle\Repository\QueryBuilder
     */
    public function joinWithAddress(QueryBuilder $qb)
    {
        $qb->join(self::ALIAS . '.address', 'address')
           ->addSelect('address');
        
        return $qb;
    }
    
}
