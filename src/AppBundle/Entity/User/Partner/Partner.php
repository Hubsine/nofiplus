<?php

namespace AppBundle\Entity\User\Partner;

use AppBundle\Entity\User\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection as DoctrineArrayCollectionInterface;
use Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber as AssertPhoneNumber;
use AppBundle\Entity\User\UserTrait;
use AppBundle\Entity\AdminEntityInterface;

/**
 * 
 * User class entity
 * 
 * @ORM\Table(name="np_user_partner")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\User\Partner\UserRepository")
 * 
 * @UniqueEntity("phone", message="assert.unique_entity.phone")
 * 
 * @author Hubsine <contact@hubsine.com>
 */
class Partner extends BaseUser implements AdminEntityInterface
{
    CONST ROUTE_PREFIX = 'user_partner';
    
    use UserTrait;

    /**
     * @var integer
     * 
     * @ORM\Column(type="phone_number")
     * 
     * @AssertPhoneNumber(defaultRegion="FR", message="assert.phone.not_phone")
     */
    protected $phone;
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public static function getRoutePrefix(): string
    {
        return self::ROUTE_PREFIX;
    }
    
    /**
     * Set phone
     *
     * @param phone_number $phone
     *
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return phone_number
     */
    public function getPhone()
    {
        return $this->phone;
    }
}