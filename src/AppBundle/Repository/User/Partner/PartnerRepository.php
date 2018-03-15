<?php

namespace AppBundle\Repository\User\Partner;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use AppBundle\Repository\User\UserRepository;
use AppBundle\Repository\RepositoryTrait;

/**
 * PartnerRepository
 */
class PartnerRepository extends UserRepository
{
    CONST ALIAS = 'e';
    
    use RepositoryTrait;
    
    public function findOneForIndex($slug)
    {
        $qb   = $this->createQueryBuilder(self::ALIAS)
                ->where('e.slug = :slug')
                ->setParameter('slug', $slug);
        
        $this->joinWithAddress($qb);
        
        return $qb->getQuery()->getOneOrNullResult();
    }
    
    public function findOneForUpdateCompagny($slug)
    {
        $qb   = $this->createQueryBuilder(self::ALIAS)
                ->where('e.slug = :slug')
                ->setParameter('slug', $slug);
        
        $this->joinWithCompagnies($qb);
        $this->joinWithCompagnyLogo($qb);
        $this->joinWithAddress($qb, 'compagny');
        
        return $qb->getQuery()->getOneOrNullResult();
    }
    
    ###
    # Joins
    ###
    
    public function joinWithCompagnies(QueryBuilder $qb)
    {
        $qb
            ->leftJoin('e.compagnies', 'compagny')
            ->addSelect('compagny');
        
        return $qb;
    }
    
    public function joinWithCompagnyLogo(QueryBuilder $qb)
    {
        $qb
            ->leftJoin('compagny.logo', 'logo')
            ->addSelect('logo');
        
        return $qb;
    }
}

