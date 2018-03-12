<?php

namespace AppBundle\Entity\User\Partner;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use AppBundle\Traits\DoctrineTrait;
use AppBundle\Entity\DateTrait;
use AppBundle\Entity\EntityInterface;

/**
 * Offre
 *
 * @ORM\Table(name="np_user_partner_offre")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\User\Partner\OffreRepository")
 * 
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 */
class Offre implements EntityInterface
{
    const ENJOY_BY_ALL      = 'all';
    const ENJOY_BY_LOCATION = 'location';
    const ENJOY_BY_WEB      = 'web';
    const ENJOY_BY_TEL      = 'tel';
    
    use DoctrineTrait;
    use DateTrait;
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\User\Partner\Compagny
     *
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\User\Partner\Compagny", inversedBy="offres")
     * 
     * @Assert\Type(type="\AppBundle\Entity\User\Partner\Compagny")
     * @Assert\Valid()
     */
    private $compagny;

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
     * @var \AppBundle\Entity\Admin\Category\Offre
     *
     * @ORM\OneToOne(targetEntity="\AppBundle\Entity\Admin\Category\Offre")
     * 
     * @Assert\Type(type="\AppBundle\Entity\Admin\Category\Offre", message="assert.type")
     */
    private $category;

    /**
     * @var \AppBundle\Entity\User\Partner\Featured
     *
     * @ORM\OneToOne(targetEntity="\AppBundle\Entity\User\Partner\Featured", mappedBy="offre", cascade={"persist", "remove"})
     * 
     * @Assert\Type(type="\AppBundle\Entity\User\Partner\Featured")
     * @Assert\Valid()
     */
    private $featured;

    /**
     * @var string
     * 
     * @ORM\Column(unique=true, name="slug")
     * @Gedmo\Slug(fields={"name", "id"})
     */
    private $slug;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=10, name="how_enjoy")
     * 
     * @Assert\NotBlank(message="assert.not_blank")
     * @Assert\Choice(callback="getHowEnjoys", message="assert.choice")
     */
    private $howEnjoy;
    
    /**
     * @var string
     *
     * @ORM\Column(name="enjoy_by_location", type="string", length=255, nullable=true)
     * 
     * @Assert\Type(type="string", message="assert.type")
     */
    private $enjoyByLocation;

    /**
     * @var string
     *
     * @ORM\Column(name="enjoy_by_web", type="string", length=255, nullable=true)
     * 
     * @Assert\Type(type="string", message="assert.type")
     */
    private $enjoyByWeb;

    /**
     * @var string
     *
     * @ORM\Column(name="enjoy_by_tel", type="string", length=255, nullable=true)
     * 
     * @Assert\Type(type="string", message="assert.type")
     */
    private $enjoyByTel;

    public static function getHowEnjoys()
    {
        return array(self::ENJOY_BY_LOCATION, self::ENJOY_BY_WEB, self::ENJOY_BY_TEL, self::ENJOY_BY_ALL);
    }

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context, $payload)
    {
        switch ( $this->getHowEnjoy() )
        {       
            /** Dans le cas où l'offre est sur "tout" il faut renseigner chaque cas **/
            case self::ENJOY_BY_ALL:
                empty( $this->getEnjoyByLocation() ) || '' === $this->getEnjoyByLocation() ? 
                    $context->buildViolation('assert.not_blank')
                        ->atPath('enjoyByLocation')
                        ->addViolation()
                    : null;

                empty( $this->getEnjoyByWeb() ) || '' === $this->getEnjoyByWeb() ? 
                    $context->buildViolation('assert.not_blank')
                        ->atPath('enjoyByWeb')
                        ->addViolation()
                    : null;

                empty( $this->getEnjoyByTel() ) || '' === $this->getEnjoyByTel() ? 
                    $context->buildViolation('assert.not_blank')
                        ->atPath('enjoyByTel')
                        ->addViolation()
                    : null;
            break;
        
            case self::ENJOY_BY_LOCATION:
                empty( $this->getEnjoyByLocation() ) || '' === $this->getEnjoyByLocation() ? 
                    $context->buildViolation('assert.not_blank')
                        ->atPath('enjoyByLocation')
                        ->addViolation()
                    : null;
                break;
            
            case self::ENJOY_BY_WEB:
                empty( $this->getEnjoyByWeb() ) || '' === $this->getEnjoyByWeb() ? 
                    $context->buildViolation('assert.not_blank')
                        ->atPath('enjoyByWeb')
                        ->addViolation()
                    : null;
                break;
            
            case self::ENJOY_BY_TEL:
                empty( $this->getEnjoyByTel() ) || '' === $this->getEnjoyByTel() ? 
                    $context->buildViolation('assert.not_blank')
                        ->atPath('enjoyByTel')
                        ->addViolation()
                    : null;
                break;

        }
    }
    
    /**
     * Get id
     *
     * @return int
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
     * @return Offre
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
     * @return Offre
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
     * Set howEnjoy
     *
     * @param string $howEnjoy
     *
     * @return Offre
     */
    public function setHowEnjoy($howEnjoy)
    {
        $this->howEnjoy = $howEnjoy;

        return $this;
    }

    /**
     * Get howEnjoy
     *
     * @return string
     */
    public function getHowEnjoy()
    {
        return $this->howEnjoy;
    }

    /**
     * Set enjoyByLocation
     *
     * @param string $enjoyByLocation
     *
     * @return Offre
     */
    public function setEnjoyByLocation($enjoyByLocation)
    {
        $this->enjoyByLocation = $enjoyByLocation;

        return $this;
    }

    /**
     * Get enjoyByLocation
     *
     * @return string
     */
    public function getEnjoyByLocation()
    {
        return $this->enjoyByLocation;
    }

    /**
     * Set enjoyByWeb
     *
     * @param string $enjoyByWeb
     *
     * @return Offre
     */
    public function setEnjoyByWeb($enjoyByWeb)
    {
        $this->enjoyByWeb = $enjoyByWeb;

        return $this;
    }

    /**
     * Get enjoyByWeb
     *
     * @return string
     */
    public function getEnjoyByWeb()
    {
        return $this->enjoyByWeb;
    }

    /**
     * Set enjoyByTel
     *
     * @param string $enjoyByTel
     *
     * @return Offre
     */
    public function setEnjoyByTel($enjoyByTel)
    {
        $this->enjoyByTel = $enjoyByTel;

        return $this;
    }

    /**
     * Get enjoyByTel
     *
     * @return string
     */
    public function getEnjoyByTel()
    {
        return $this->enjoyByTel;
    }

    /**
     * Set compagny
     *
     * @param \AppBundle\Entity\User\Partner\Compagny $compagny
     *
     * @return Offre
     */
    public function setCompagny(\AppBundle\Entity\User\Partner\Compagny $compagny = null)
    {
        $this->compagny = $compagny;

        return $this;
    }

    /**
     * Get compagny
     *
     * @return \AppBundle\Entity\User\Partner\Compagny
     */
    public function getCompagny()
    {
        return $this->compagny;
    }

    /**
     * Set category
     *
     * @param \AppBundle\Entity\Admin\Category\Offre $category
     *
     * @return Offre
     */
    public function setCategory(\AppBundle\Entity\Admin\Category\Offre $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Admin\Category\Offre
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set featured
     *
     * @param \AppBundle\Entity\User\Partner\Featured $featured
     *
     * @return Offre
     */
    public function setFeatured(\AppBundle\Entity\User\Partner\Featured $featured = null)
    {
        $this->featured = $featured;

        return $this;
    }

    /**
     * Get featured
     *
     * @return \AppBundle\Entity\User\Partner\Featured
     */
    public function getFeatured()
    {
        return $this->featured;
    }
}
