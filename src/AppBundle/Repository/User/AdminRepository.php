<?php

namespace AppBundle\Repository\User;

use Doctrine\ORM\EntityRepository;
use AppBundle\Repository\RepositoryTrait;

/**
 * AdminRepository
 */
class AdminRepository extends EntityRepository
{
    use RepositoryTrait;
}
