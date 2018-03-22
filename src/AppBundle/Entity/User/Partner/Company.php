<?php

namespace AppBundle\Entity\User\Partner;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use Doctrine\Common\Collections\Collection;
use AppBundle\Traits\DoctrineTrait;
use AppBundle\Traits\EntityRoutePrefixTrait;
use AppBundle\Entity\AdminEntityInterface;

/**
 * Company
 *
 * @ORM\Table(name="np_user_partner_company")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\User\Partner\CompanyRepository")
 * 
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 * 
 */
class Company implements AdminEntityInterface
{
    const ROUTE_PREFIX  = 'user_partner_company';
    
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
     * @Assert\NotBlank(message="assert.not_blank", groups={"new"})
     * @Assert\Type(type="string", message="assert.type", groups={"new"})
     */
    private $name;
    
    /**
     * @var string
     *
     * @ORM\Column(name="about", type="text", length=255)
     * 
     * @Assert\NotBlank(message="assert.not_blank", groups={"new"})
     * @Assert\Type(type="string", message="assert.type", groups={"new"})
     */
    private $about;

    /**
     * @var string
     * 
     * @ORM\OneToOne(targetEntity="\AppBundle\Entity\Address", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Assert\NotBlank(message="assert.not_blank", groups={"new"})
     * @Assert\Type(type="\AppBundle\Entity\Address", groups={"new"})
     * @Assert\Valid()
     */
    private $address;

    /**
     * @var \AppBundle\Entity\User\Partner\CompanyLogo
     * 
     * @ORM\OneToOne(targetEntity="\AppBundle\Entity\User\Partner\CompanyLogo", mappedBy="company", orphanRemoval=true, cascade={"all"})
     * @ORM\JoinColumn(nullable=true)
     * 
     * @Assert\NotBlank(message="assert.not_blank", groups={"new"})
     * @Assert\Type(type="\AppBundle\Entity\User\Partner\CompanyLogo", groups={"new"})
     * @Assert\Valid()
     */
    private $logo;

    /**
     * @var \AppBundle\Entity\User\Partner\Partner
     * 
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\User\Partner\Partner", inversedBy="compagnies")
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Assert\Type(type="\AppBundle\Entity\User\Partner\Partner", groups={"new"})
     */
    private $partner;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\User\Partner\Offre", mappedBy="company", cascade={"all"})
     * 
     * @Assert\Type(type="\Doctrine\Common\Collections\Collection", message="assert.type")
     */
    private $offres;

    /**
     * @var \AppBundle\Entity\Admin\Category\Company
     *
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Admin\Category\Company")
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Assert\NotBlank(message="assert.not_blank", groups={"new"})
     * @Assert\Type(type="\AppBundle\Entity\Admin\Category\Company", message="assert.type", groups={"new"})
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
     * @return Company
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
     * @return Company
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
     * @return Company
     */
    public function setAddress(\AppBundle\Entity\Address $address)
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
     * @param \AppBundle\Entity\User\Partner\CompanyLogo $logo
     *
     * @return Company
     */
    public function setLogo(\AppBundle\Entity\User\Partner\CompanyLogo $logo)
    {
        $this->logo = $logo;
        
        $logo->setCompany($this);

        return $this;
    }

    /**
     * Get logo
     *
     * @return \AppBundle\Entity\User\Partner\CompanyLogo
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
     * @return Company
     */
    public function setPartner(\AppBundle\Entity\User\Partner\Partner $partner)
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
     * @return Company
     */
    public function addOffre(\AppBundle\Entity\User\Partner\Offre $offre)
    {
        $this->offres[] = $offre;
        
        $offre->setCompany($this);

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
     * @param \AppBundle\Entity\Admin\Category\Company $category
     *
     * @return Company
     */
    public function setCategory(\AppBundle\Entity\Admin\Category\Company $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Admin\Category\Company
     */
    public function getCategory()
    {
        return $this->category;
    }
}
