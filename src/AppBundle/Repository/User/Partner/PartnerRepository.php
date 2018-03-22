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
        $this->joinWithCompanyOffres($qb, 'company');
        $this->joinWithCompanyLogo($qb, 'company');
        $this->joinWithAddress($qb, 'company');
        
        return $qb->getQuery()->getOneOrNullResult();
    }
    
    public function findOneForUpdateCompany($slug)
    {
        $qb   = $this->createQueryBuilder(self::ALIAS)
                ->where('e.slug = :slug')
                ->setParameter('slug', $slug);
        
        $this->joinWithCompagnies($qb);
        $this->joinWithCompanyLogo($qb, 'company');
        $this->joinWithAddress($qb, 'company');
        
        return $qb->getQuery()->getOneOrNullResult();
    }
    
    ###
    # Joins
    ###
    
    public function joinWithCompagnies(QueryBuilder $qb)
    {
        $qb
            ->leftJoin('e.compagnies', 'company')
            ->addSelect('company');
        
        return $qb;
    }
    
    public function joinWithCompanyLogo(QueryBuilder $qb, $alias)
    {
        $qb
            ->leftJoin($alias . '.logo', 'logo')
            ->addSelect('logo');
        
        return $qb;
    }
    
    public function joinWithCompanyOffres(QueryBuilder $qb, $alias)
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

