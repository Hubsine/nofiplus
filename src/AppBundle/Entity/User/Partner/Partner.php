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
use AppBundle\Traits\EntityRoutePrefixTrait;
use AppBundle\Entity\AdminEntityInterface;
use libphonenumber\PhoneNumberType;

/**
 * 
 * User class entity
 * 
 * @ORM\Table(name="np_user_partner")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\User\Partner\PartnerRepository")
 * 
 * @UniqueEntity("phoneMobile", message="assert.unique_entity.phone")
 * 
 * @author Hubsine <contact@hubsine.com>
 */
class Partner extends BaseUser implements AdminEntityInterface
{
    CONST ROUTE_PREFIX  = 'user_partner';
    CONST ROLE_PARTNER  = 'ROLE_PARTNER';
    
    use UserTrait;
    use EntityRoutePrefixTrait;

    /**
     * @var integer
     * 
     * @ORM\Column(type="phone_number", unique=true, nullable=true)
     * 
     * @AssertPhoneNumber(defaultRegion="FR", type="MOBILE", message="assert.phone.not_mobile_phone")
     */
    protected $phoneMobile;
    
    /**
     * @var integer
     * 
     * @ORM\Column(type="phone_number", nullable=true)
     * 
     * @AssertPhoneNumber(defaultRegion="FR", type="FIXED_LINE", message="assert.phone.not_mobile_phone")
     */
    protected $phoneFixed;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\User\Partner\Company", mappedBy="partner", cascade={"persist", "remove"})
     * 
     * @Assert\Type(type="\Doctrine\Common\Collections\Collection", message="assert.type")
     * @Assert\Valid()
     */
    protected $compagnies;

    public function __construct()
    {
        parent::__construct();
        
        $this->addRole(self::ROLE_PARTNER);        
        $this->compagnies = new ArrayCollection();
    }
    
    public function isAdmin()
    {
        return false;
    }

    public function isPartner()
    {
        return true;
    }
    
    public function isAbonne()
    {
        return false;
    }
    
    /**
     * Set phoneMobile
     *
     * @param mixed $phoneMobile
     *
     * @return Partner
     */
    public function setPhoneMobile($phoneMobile)
    {
        $this->phoneMobile = $phoneMobile;

        return $this;
    }

    /**
     * Get phoneMobile
     *
     * @return mixed
     */
    public function getPhoneMobile()
    {
        return $this->phoneMobile;
    }

    /**
     * Set phoneFixed
     *
     * @param mixed $phoneFixed
     *
     * @return Partner
     */
    public function setPhoneFixed($phoneFixed)
    {
        $this->phoneFixed = $phoneFixed;

        return $this;
    }

    /**
     * Get phoneFixed
     *
     * @return mixed
     */
    public function getPhoneFixed()
    {
        return $this->phoneFixed;
    }

    /**
     * Add company
     *
     * @param \AppBundle\Entity\User\Partner\Company $company
     *
     * @return Partner
     */
    public function addCompany(\AppBundle\Entity\User\Partner\Company $company)
    {
        $this->compagnies[] = $company;

        $company->setPartner($this);
        
        return $this;
    }

    /**
     * Remove company
     *
     * @param \AppBundle\Entity\User\Partner\Company $company
     */
    public function removeCompany(\AppBundle\Entity\User\Partner\Company $company)
    {
        $this->compagnies->removeElement($company);
    }

    /**
     * Get compagnies
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompagnies()
    {
        return $this->compagnies;
    }
}
