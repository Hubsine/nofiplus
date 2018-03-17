<?php

namespace AppBundle\Entity\Admin\Category;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Hubsine <contact@hubsine.com>
 */
trait CategoryTrait 
{
    /**
     * @var string
     * 
     * @ORM\Column(name="name", type="string")
     * 
     * @Assert\NotBlank(message="assert.not_blank")
     * @Assert\Type(type="string", message="assert.type")
     */
    private $name;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="about", type="text", nullable=true)
     * 
     * @Assert\Type(type="string", message="assert.type")
     */
    private $about;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="slug")
     * @Gedmo\Slug(fields={"name"})
     */
    private $slug;
    
    public function getName()
    {
        return $this->name;
    }
    
    public function setName($name)
    {
        $this->name = $name;
        
        return $this;
    }
    
    /**
     * Set about
     *
     * @param string $about
     *
     * @return Carte
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
     * @return User
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
}
