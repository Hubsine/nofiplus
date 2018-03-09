<?php

namespace AppBundle\Entity\Media;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Description of Media
 * 
 * @author Hubsine <contact@hubsine.com>
 */
trait MediaTrait
{
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
     * @ORM\Column(name="name", type="string")
     * 
     * @Assert\Type(type="string", message="assert.type")
     * 
     * @Gedmo\UploadableFileName
     */
    private $name;
    
    /**
     * @var string file extension
     * 
     * @ORM\Column(name="extension", type="string")
     * 
     * @Assert\Type(type="string", message="assert.type")
     */
    private $extension;
    
    /**
     * @var string 
     * 
     * @ORM\Column(name="path", type="string")
     * 
     * @Gedmo\UploadableFilePath
     */
    private $path;

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
     * @return Media
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
     * Set extension
     *
     * @param string $extension
     *
     * @return Media
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get extension
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set path
     *
     * @param string $path
     *
     * @return Media
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }
    
    /**
     * After file is moved
     * 
     * @param array $infos
     */
    public function afterFileMove(array $infos)
    {
        $this->setExtension($infos['fileExtension']);
    }
}
