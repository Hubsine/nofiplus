<?php

namespace AppBundle\Repository\User;

use Doctrine\ORM\EntityRepository;
use AppBundle\Repository\RepositoryTrait;
use AppBundle\Entity\User\User;

/**
 * UserRepository
 */
class UserRepository extends EntityRepository
{
    use RepositoryTrait;
    
    public function findByUniqueCriteria(array $criteria)
    {
        // would use findOneBy() but Symfony expects a Countable object
        return $this->_em->getRepository(User::class)->findBy($criteria);
    }
}
