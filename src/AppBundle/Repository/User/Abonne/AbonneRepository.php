<?php

namespace AppBundle\Repository\User\Abonne;

use AppBundle\Repository\User\UserRepository;
use Doctrine\ORM\QueryBuilder;

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
        
        $this->joinWithOrders($qb);
        $this->joinWithCartes($qb);
        $this->joinWithAddress($qb, self::ALIAS);
        
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
    
    ###
    # Joins
    ###
    
    public function joinWithCartes(QueryBuilder $qb)
    {
        $qb
            ->leftJoin(self::ALIAS . '.cartes', 'carte')
            ->addSelect('carte')
            ;
        
        return $qb;
    }
    
    public function joinWithOrders(QueryBuilder $qb)
    {
        $qb
            ->leftJoin(self::ALIAS . '.orderCartes', 'orderCarte')
            ->addSelect('orderCarte')
            ->leftJoin('orderCarte.paymentInstruction', 'instruction')
            ->addSelect('instruction')
            ->leftJoin('instruction.payments', 'payment')
            ->addSelect('payment') 
            ->leftJoin('payment.transactions', 'transaction')
            ->addSelect('transaction')     
            ;
        
        return $qb;
    }
}
