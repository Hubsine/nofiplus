<?php

namespace AppBundle\Repository\User\Abonne;

use Doctrine\ORM\EntityRepository;
use AppBundle\Repository\User\UserRepository;
use AppBundle\Repository\RepositoryTrait;

/**
 * AbonneRepository
 */
class AbonneRepository extends UserRepository
{
    const ALIAS = 'a';
    
    public function findOneForShow($slug)
    {
        $qb = $this
                ->createQueryBuilder(self::ALIAS)
                ->where('a.slug = :slug')
                ->setParameter('slug', $slug)
                ;
        
        return $qb->getQuery()->getOneOrNullResult();
    }
    
    public function findOneForUpdate($slug)
    {
        $qb = $this
                ->createQueryBuilder(self::ALIAS)
                ->where('a.slug = :slug')
                ->setParameter('slug', $slug)
                ;
        
        return $qb->getQuery()->getOneOrNullResult();
    }
}
