<?php

namespace AppBundle\Repository\User\Partner;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use AppBundle\Repository\RepositoryTrait;

/**
 * PartnerRepository
 */
class PartnerRepository extends EntityRepository
{
    CONST ALIAS = 'e';
    
    use RepositoryTrait;
    
    public function findOneForIndex($id)
    {
        $qb   = $this->createQueryBuilder(self::ALIAS)
                ->where('e.id = :id')
                ->setParameter('id', $id);
        
        $this->joinWithAddress($qb);
        
        return $qb->getQuery()->getOneOrNullResult();
    }
}
