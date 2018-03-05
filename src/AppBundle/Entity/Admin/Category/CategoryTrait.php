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
     * @Assert\Type(type="alpha", message="assert.type")
     */
    private $name;
    
    public function getName()
    {
        return $this->name;
    }
    
    public function setName($name)
    {
        $this->name = $name;
        
        return $this;
    }
}
