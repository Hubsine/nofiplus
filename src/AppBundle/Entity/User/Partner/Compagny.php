<?php

namespace AppBundle\Entity\User\Partner;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use AppBundle\Traits\DoctrineTrait;
use AppBundle\Traits\EntityRoutePrefixTrait;
use AppBundle\Entity\AdminEntityInterface;

/**
 * Compagny
 *
 * @ORM\Table(name="np_user_partner_compagny")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\User\Partner\CompagnyRepository")
 * 
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 * 
 */
class Compagny implements AdminEntityInterface
{
    const ROUTE_PREFIX  = 'user_partner_compagny';
    
    use DoctrineTrait;
    use EntityRoutePrefixTrait;
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * 
     * @Assert\NotBlank(message="assert.not_blank")
     * @Assert\Type(type="string", message="assert.type")
     */
    private $name;
    
    /**
     * @var string
     *
     * @ORM\Column(name="about", type="string", length=255)
     * 
     * @Assert\NotBlank(message="assert.not_blank")
     * @Assert\Type(type="string", message="assert.type")
     */
    private $about;

    /**
     * @var string
     * 
     * @ORM\OneToOne(targetEntity="\AppBundle\Entity\Address", cascade={"persist", "remove"})
     * 
     * @Assert\NotBlank(message="assert.not_blank")
     * @Assert\Type(type="\AppBundle\Entity\Address")
     * @Assert\Valid()
     */
    private $address;

    /**
     * @var \AppBundle\Entity\User\Partner\CompagnyLogo
     * 
     * @ORM\OneToOne(targetEntity="\AppBundle\Entity\User\Partner\CompagnyLogo", mappedBy="compagny", cascade={"persist", "remove"})
     * 
     * @Assert\NotBlank(message="assert.not_blank")
     * @Assert\Type(type="\AppBundle\Entity\User\Partner\CompagnyLogo")
     * @Assert\Valid()
     */
    private $logo;

    /**
     * @var \AppBundle\Entity\User\Partner\Partner
     * 
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\User\Partner\Partner", inversedBy="compagnies")
     * 
     * @Assert\Type(type="\AppBundle\Entity\User\Partner\Partner")
     * @Assert\Valid()
     */
    private $partner;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\User\Partner\Offre", mappedBy="compagny", cascade={"persist", "remove"})
     * 
     * @Assert\NotBlank(message="assert.not_blank")
     * @Assert\Type(type="\Doctrine\ORM\PersistentCollection", message="assert.type")
     * @Assert\Valid()
     */
    private $offres;

    /**
     * @var \AppBundle\Entity\Admin\Category\Compagny
     *
     * @ORM\OneToOne(targetEntity="\AppBundle\Entity\Admin\Category\Compagny")
     * 
     * @Assert\NotBlank(message="assert.not_blank")
     * @Assert\Type(type="\AppBundle\Entity\Admin\Category\Compagny", message="assert.type")
     */
    private $category;

   /**
     * @var string
     * 
     * @ORM\Column(unique=true, name="slug")
     * @Gedmo\Slug(fields={"name", "id"})
     */
    private $slug;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->offres = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Compagny
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set about
     *
     * @param string $about
     *
     * @return Offre
     */
    public function setAbout($about)
    {
        $this->about = $about;

        return $this;
    }

    /**
     * Get about
     *
     * @return string
     */
    public function getAbout()
    {
        return $this->about;
    }
    
    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Compagny
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

    /**
     * Set address
     *
     * @param \AppBundle\Entity\Address $address
     *
     * @return Compagny
     */
    public function setAddress(\AppBundle\Entity\Address $address = null)
    {
        $this->address = $address;

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
     * Set logo
     *
     * @param \AppBundle\Entity\User\Partner\CompagnyLogo $logo
     *
     * @return Compagny
     */
    public function setLogo(\AppBundle\Entity\User\Partner\CompagnyLogo $logo = null)
    {
        $this->logo = $logo;
        
        $logo->setCompagny();

        return $this;
    }

    /**
     * Get logo
     *
     * @return \AppBundle\Entity\User\Partner\CompagnyLogo
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set partner
     *
     * @param \AppBundle\Entity\User\Partner\Partner $partner
     *
     * @return Compagny
     */
    public function setPartner(\AppBundle\Entity\User\Partner\Partner $partner = null)
    {
        $this->partner = $partner;
        
        return $this;
    }

    /**
     * Get partner
     *
     * @return \AppBundle\Entity\User\Partner\Partner
     */
    public function getPartner()
    {
        return $this->partner;
    }

    /**
     * Add offre
     *
     * @param \AppBundle\Entity\User\Partner\Offre $offre
     *
     * @return Compagny
     */
    public function addOffre(\AppBundle\Entity\User\Partner\Offre $offre)
    {
        $this->offres[] = $offre;
        
        $offre->setCompagny($this);

        return $this;
    }

    /**
     * Remove offre
     *
     * @param \AppBundle\Entity\User\Partner\Offre $offre
     */
    public function removeOffre(\AppBundle\Entity\User\Partner\Offre $offre)
    {
        $this->offres->removeElement($offre);
    }

    /**
     * Get offres
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOffres()
    {
        return $this->offres;
    }

    /**
     * Set category
     *
     * @param \AppBundle\Entity\Admin\Category\Compagny $category
     *
     * @return Compagny
     */
    public function setCategory(\AppBundle\Entity\Admin\Category\Compagny $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Admin\Category\Compagny
     */
    public function getCategory()
    {
        return $this->category;
    }
}
