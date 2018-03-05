<?php

namespace AppBundle\Entity\Media;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping\MappedSuperclass;
use Gedmo\Mapping\Annotation as Gedmo;
use AppBundle\Entity\Media\MediaTrait;

/**
 * Description of Profile
 * 
 * @author Hubsine <contact@hubsine.com>
 */
trait ImageTrait
{
    use MediaTrait;
    
    /**
     * @var string 
     * 
     * @ORM\Column(name="mime_type", type="string")
     * @Gedmo\UploadableFileMimeType
     * 
     */
    private $mimeType;

    /**
     * @var integer
     * 
     * @ORM\Column(name="size", type="decimal")
     * @Gedmo\UploadableFileSize
     */
    private $size;

    /**
     * @var \Symfony\Component\HttpFoundation\File\UploadedFile
     * 
     * @Assert\Image(maxSize="2M", maxSizeMessage="assert.file.max_size", mimeTypesMessage="assert.file.mime_types")
     */
    private $file;

    /**
     * Set mimeType
     *
     * @param string $mimeType
     *
     * @return Image
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    /**
     * Get mimeType
     *
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * Set size
     *
     * @param string $size
     *
     * @return Image
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }
    
    /**
     * Set File
     * 
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @return $this
     */
    public function setFile(\Symfony\Component\HttpFoundation\File\UploadedFile $file)
    {
        $this->file = $file;
        
        return $this;
    }


    /**
     * Get File 
     * 
     * @return \Symfony\Component\HttpFoundation\File\UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }
    
    /**
     * Get upload folder
     * 
     * @return string
     */
    public function getPath(): string
    {
        return self::FOLDER;
    }
}
