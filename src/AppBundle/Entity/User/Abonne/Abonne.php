<?php

namespace AppBundle\Entity\User\Abonne;

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
 * @ORM\Table(name="np_user_abonne")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\User\Abonne\UserRepository")
 * 
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 * 
 * @UniqueEntity("phone", message="assert.unique_entity.phone")
 * 
 * @author Hubsine <contact@hubsine.com>
 */
class Abonne extends BaseUser implements AdminEntityInterface
{
    CONST ROUTE_PREFIX = 'user_abonne';
    
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
    
    /**
     * @var avatar
     * 
     * @ORM\OneToOne(targetEntity="\AppBundle\Entity\User\Abonne\Avatar", mappedBy="user", cascade={"persist", "remove"})
     * 
     * @Assert\Type(type="\AppBundle\Entity\User\Abonne\Avatar")
     * @Assert\Valid()
     */
    protected $avatar;
    
    /**
     * Set avatar
     *
     * @param \AppBundle\Entity\User\Abonne\Avatar $avatar
     *
     * @return User
     */
    public function setAvatar(\AppBundle\Entity\User\Abonne\Avatar $avatar)
    {
        $this->avatar = $avatar;
        
        $avatar->setUser($this);

        return $this;
    }

    /**
     * Get avatar
     *
     * @return \AppBundle\Entity\User\Abonne\Avatar
     */
    public function getAvatar()
    {
        return $this->avatar;
    }
}
