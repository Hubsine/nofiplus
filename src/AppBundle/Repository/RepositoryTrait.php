<?php

namespace AppBundle\Repository;

use Doctrine\ORM\QueryBuilder;
use AppBundle\Exception\UndefinedConstantException;

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
     * @param string $alias Alias of entity 
     * @return \AppBundle\Repository\QueryBuilder
     */
    public function joinWithAddress(QueryBuilder $qb, $alias)
    {
        $qb->leftJoin($alias . '.address', 'address_' . $alias)
           ->addSelect('address_' . $alias);
        
        return $qb;
    }
    
}
