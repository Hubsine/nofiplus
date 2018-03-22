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
 * CompanyLogo
 *
 * @ORM\Table(name="np_user_partner_company_logo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\User\Partner\CompanyLogoRepository")
 * 
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 * @Vich\Uploadable
 */
class CompanyLogo implements EntityInterface, MediaInterface
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
     * @var \AppBundle\Entity\User\Partner\Company
     * 
     * @ORM\OneToOne(targetEntity="\AppBundle\Entity\User\Partner\Company", inversedBy="logo")
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Assert\NotBlank(message="assert.not_blank")
     * @Assert\Type(type="\AppBundle\Entity\User\Partner\Company")
     */
    private $company;
    
    /**
     * @var \Symfony\Component\HttpFoundation\File\UploadedFile
     * 
     * @Vich\UploadableField(
     *  mapping="company_logo", 
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
     * Set company
     *
     * @param \AppBundle\Entity\User\Partner\Company $company
     *
     * @return CompanyLogo
     */
    public function setCompany(\AppBundle\Entity\User\Partner\Company $company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return \AppBundle\Entity\User\Partner\Company
     */
    public function getCompany()
    {
        return $this->company;
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
