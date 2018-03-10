<?php

namespace AppBundle\Entity\User\Partner;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Traits\DoctrineTrait;
use AppBundle\Entity\Media\ImageTrait;
use AppBundle\Entity\Media\MediaInterface;

/**
 * CompagnyLogo
 *
 * @ORM\Table(name="np_user_partner_compagny_logo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\User\Partner\CompagnyLogoRepository")
 * 
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 */
class CompagnyLogo implements MediaInterface
{
    const FOLDER = 'uploads/compagny/logos';
    
    use DoctrineTrait;
    use ImageTrait;
    
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
     * @ORM\OneToOne(targetEntity="\AppBundle\Entity\User\Partner\Compagny", inversedBy="logo")
     * 
     * @Assert\Type(type="\AppBundle\Entity\User\Partner\Compagny")
     */
    private $compagny;

    /**
     * Set compagny
     *
     * @param \AppBundle\Entity\User\Partner\Compagny $compagny
     *
     * @return CompagnyLogo
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
}
