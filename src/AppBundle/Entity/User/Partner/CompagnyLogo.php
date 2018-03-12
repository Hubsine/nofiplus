<?php

namespace AppBundle\Entity\User\Partner;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use AppBundle\Traits\DoctrineTrait;
use AppBundle\Entity\Media\ImageTrait;
use AppBundle\Entity\EntityInterface;
use AppBundle\Entity\Media\MediaInterface;

/**
 * CompagnyLogo
 *
 * @ORM\Table(name="np_user_partner_compagny_logo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\User\Partner\CompagnyLogoRepository")
 * 
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 * @Vich\Uploadable
 */
class CompagnyLogo implements EntityInterface, MediaInterface
{
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
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Assert\NotBlank(message="assert.not_blank")
     * @Assert\Type(type="\AppBundle\Entity\User\Partner\Compagny")
     */
    private $compagny;
    
    /**
     * @var \Symfony\Component\HttpFoundation\File\UploadedFile
     * 
     * @Vich\UploadableField(
     *  mapping="compagny_logo", 
     *  fileNameProperty="name", 
     *  size="size", 
     *  mimeType="mimeType", 
     *  originalName="originalName", 
     *  dimensions="dimensions"
     * )
     * 
     * @Assert\Image(maxSize="2M", maxSizeMessage="assert.file.max_size", mimeTypesMessage="assert.file.mime_types")
     */
    private $file;

    /**
     * Set compagny
     *
     * @param \AppBundle\Entity\User\Partner\Compagny $compagny
     *
     * @return CompagnyLogo
     */
    public function setCompagny(\AppBundle\Entity\User\Partner\Compagny $compagny)
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
