<?php

namespace AppBundle\Repository\User;

use Doctrine\ORM\EntityRepository;
use AppBundle\Repository\RepositoryTrait;

/**
 * UserRepository
 */
class UserRepository extends EntityRepository
{
    use RepositoryTrait;
}
