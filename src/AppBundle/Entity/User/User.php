<?php

namespace AppBundle\Entity\User;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Traits\DoctrineTrait;
use AppBundle\Entity\AdminEntityInterface;

/**
 * User class entity
 * 
 * @ORM\Table(name="np_user_admin")
 * @ORM\Entity(repositoryClass="\AppBundle\Repository\User\UserRepository")
 * 
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 * 
 * @author Hubsine <contact@hubsine.com>
 */
class User extends BaseUser implements AdminEntityInterface
{
    CONST ROUTE_PREFIX = 'user_admin';
    
    use DoctrineTrait;
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public static function getRoutePrefix(): string
    {
        return self::ROUTE_PREFIX;
    }
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
}
