<?php

namespace AppBundle\Entity\User\Partner;

use AppBundle\Entity\User\AbstractUser as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection as DoctrineArrayCollectionInterface;
use Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber as AssertPhoneNumber;
use AppBundle\Traits\DoctrineTrait;
use AppBundle\Entity\AdminEntityInterface;

/**
 * 
 * User class entity
 * 
 * @ORM\Table(name="np_user_partner")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\User\Partner\UserRepository")
 * 
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 * 
 * @UniqueEntity("phone", message="assert.unique_entity.phone")
 * 
 * @author Hubsine <contact@hubsine.com>
 */
class Partner extends BaseUser implements AdminEntityInterface
{
    CONST ROUTE_PREFIX = 'user_partner';
    
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