<?php

namespace AppBundle\Entity\Admin\Pages;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Hubsine <contact@hubsine.com>
 */
trait PageTrait 
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
     * @Gedmo\Translatable
     * 
     * @ORM\Column(name="title", type="string", length=255)
     * 
     * @Assert\NotBlank(message="assert.not_blank")
     * @Assert\Type(type="string", message="assert.type")
     */
    private $title;
    
    /**
     * @var string
     *
     * @Gedmo\Translatable
     * 
     * @ORM\Column(name="content", type="string", length=255)
     * 
     * @Assert\NotBlank(message="assert.not_blank")
     * @Assert\Type(type="string", message="assert.type")
     */
    private $content;
    
    /**
     * @var string
     * 
     * @ORM\Column(unique=true, name="slug")
     * @Gedmo\Slug(fields={"title"})
     * 
     */
    protected $slug;
    
    /**
     * @Gedmo\Locale
     * 
     * Assert\NotBlank(message="assert.not_blank")
     * @Assert\Locale()
     */
    private $locale;
    
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
     * Set title
     *
     * @param string $title
     *
     * @return Page
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * Set content
     *
     * @param string $content
     *
     * @return Page
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }
    
    /**
     * Set slug
     *
     * @return Page
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
    
    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }
    
    public function getLocale()
    {
        return $this->locale;
    }
    
    public function setLocale($locale)
    {
        $this->locale   = $locale;
        
        return $this;
    }
}
