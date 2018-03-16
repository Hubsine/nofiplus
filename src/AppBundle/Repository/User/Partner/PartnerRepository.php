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
        
        $this->joinWithAddress($qb, 'e');
        $this->joinWithCompagnies($qb);
        $this->joinWithCompagnyOffres($qb, 'compagny');
        $this->joinWithCompagnyLogo($qb, 'compagny');
        $this->joinWithAddress($qb, 'compagny');
        
        return $qb->getQuery()->getOneOrNullResult();
    }
    
    public function findOneForUpdateCompagny($slug)
    {
        $qb   = $this->createQueryBuilder(self::ALIAS)
                ->where('e.slug = :slug')
                ->setParameter('slug', $slug);
        
        $this->joinWithCompagnies($qb);
        $this->joinWithCompagnyLogo($qb, 'compagny');
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
    
    public function joinWithCompagnyLogo(QueryBuilder $qb, $alias)
    {
        $qb
            ->leftJoin($alias . '.logo', 'logo')
            ->addSelect('logo');
        
        return $qb;
    }
    
    public function joinWithCompagnyOffres(QueryBuilder $qb, $alias)
    {
        $qb
            ->leftJoin($alias . '.offres', 'offre')
            ->addSelect('offre')
            ->leftJoin('offre.featured', 'featured')
            ->addSelect('featured')
            ;
        
        return $qb;
    }
}

