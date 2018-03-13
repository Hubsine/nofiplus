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
 * Featured
 *
 * @ORM\Table(name="np_user_partner_featured")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\User\Partner\FeaturedRepository")
 * 
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 * @Vich\Uploadable
 */
class Featured implements EntityInterface, MediaInterface
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
     * @var string
     *
     * @ORM\OneToOne(targetEntity="\AppBundle\Entity\User\Partner\Offre", inversedBy="featured")
     * 
     * @Assert\NotBlank(message="assert.not_blank")
     * @Assert\Type(type="\AppBundle\Entity\User\Partner\Offre")
     */
    private $offre;

    /**
     * @var \Symfony\Component\HttpFoundation\File\UploadedFile
     * 
     * @Vich\UploadableField(
     *  mapping="offre_featured", 
     *  fileNameProperty="name", 
     *  size="size", 
     *  mimeType="mimeType", 
     *  originalName="originalName", 
     *  dimensions="dimensions"
     * )
     * 
     * @Assert\Image(
     *  maxSize="2M", 
     *  maxSizeMessage="assert.file.max_size", 
     *  mimeTypesMessage="assert.file.mime_types"
     * )
     */
    private $file;
    
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
     * Set offre
     *
     * @param \AppBundle\Entity\User\Partner\Offre $offre
     *
     * @return Featured
     */
    public function setOffre(\AppBundle\Entity\User\Partner\Offre $offre = null)
    {
        $this->offre = $offre;

        return $this;
    }

    /**
     * Get offre
     *
     * @return \AppBundle\Entity\User\Partner\Offre
     */
    public function getOffre()
    {
        return $this->offre;
    }
}
