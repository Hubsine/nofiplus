<?php

namespace AppBundle\Entity\User;

use AppBundle\Entity\User\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\AdminEntityInterface;
use AppBundle\Traits\EntityRoutePrefixTrait;

/**
 * User Admin class entity
 * 
 * @ORM\Table(name="np_user_admin")
 * @ORM\Entity(repositoryClass="\AppBundle\Repository\User\AdminRepository")
 * 
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 * 
 * @author Hubsine <contact@hubsine.com>
 */
class Admin extends BaseUser implements AdminEntityInterface
{
    CONST ROUTE_PREFIX = 'user_admin';
    
    use EntityRoutePrefixTrait;
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function isAdmin()
    {
        return true;
    }
    
    public function isPartner()
    {
        return false;
    }
    
    public function isAbonne()
    {
        return false;
    }
}
