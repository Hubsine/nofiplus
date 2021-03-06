<?php

namespace AppBundle\Entity\Media;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Description of MediaTrait
 * 
 * @author Hubsine <contact@hubsine.com>
 */
trait MediaTrait
{
    /**
     * @var string 
     * 
     * @ORM\Column(name="name", type="string", nullable=true)
     * 
     * @Assert\Type(type="string", message="assert.type")
     */
    private $name;
    
    /**
     * @ORM\Column(name="original_name", nullable=true)
     * 
     * @Assert\Type(type="string", message="assert.type")
     */
    private $originalName;
    
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
    
    public function getOriginalName()
    {
        return $this->originalName;
    }

    public function setOriginalName(string $originalName = null)
    {
        $this->originalName = $originalName;
    }
}
