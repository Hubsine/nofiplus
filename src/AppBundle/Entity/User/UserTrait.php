<?php

namespace AppBundle\Entity\User;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User trait
 * 
 * @author Hubsine <contact@hubsine.com>
 */
trait UserTrait
{
    /**
     * @var string
     * 
     * @ORM\OneToOne(targetEntity="\AppBundle\Entity\Address", cascade={"persist", "remove"})
     * 
     * @Assert\Type(type="\AppBundle\Entity\Address")
     * @Assert\Valid()
     */
    protected $address;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=10, name="gender", nullable=true)
     * 
     * @Assert\Choice(callback="getGenders", message="assert.choice")
     */
    protected $gender;
    
    /**
     * @var DateTime
     * 
     * @ORM\Column(type="date", nullable=true)
     * 
     * @Assert\Date(message="assert.date.birthday")
     */
    protected $birthday;
    
    /**
     * @var string
     * 
     * @ORM\Column(unique=true, name="slug")
     * @Gedmo\Slug(fields={"username", "id"})
     * 
     */
    protected $slug;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="first_name", type="string", nullable=true)
     * 
     * @Assert\Type(type="alpha", message="assert.type")
     * @Assert\Length(max=20, maxMessage="assert.length.max")
     * 
     */
    protected $firstName;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="last_name", type="string", nullable=true)
     * 
     * @Assert\Type(type="alpha", message="assert.type")
     * @Assert\Length(max=50, maxMessage="assert.length.max")
     */
    protected $lastName;
    
    /**
     * Get Genders 
     * 
     * @return array
     */
    public static function getGenders()
    {
        return array("male", "female");
    }
    
    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set address
     *
     * @param \AppBundle\Entity\Address $address
     *
     * @return User
     */
    public function setAddress(\AppBundle\Entity\Address $address = null)
    {
        $this->address = $address;
        
        $address->setUser($this);

        return $this;
    }

    /**
     * Get address
     *
     * @return \AppBundle\Entity\Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set gender
     *
     * @param string $gender
     *
     * @return User
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set birthday
     *
     * @param \DateTime $birthday
     *
     * @return User
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return User
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
}
