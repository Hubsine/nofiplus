<?php

namespace AppBundle\Entity\Admin\Pages;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\EntityInterface;
use AppBundle\Entity\AdminEntityInterface;
use AppBundle\Traits\DoctrineTrait;
use AppBundle\Traits\EntityRoutePrefixTrait;
use AppBundle\Entity\Admin\Pages\PageTrait;

/**
 * Page
 *
 * @ORM\Table(name="np_pages_maintenance")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Admin\Pages\MaintenanceRepository")
 * 
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 */
class Maintenance implements EntityInterface, AdminEntityInterface, Translatable
{
    const ROUTE_PREFIX  = 'pages_maintenance';
    
    use DoctrineTrait;
    use EntityRoutePrefixTrait;
    use PageTrait;
    
    /**
     * @var boolean
     * 
     * @ORM\Column(name="enable", type="boolean")
     * 
     * @Assert\Type(type="boolean", message="assert.type")
     */
    private $enable;
    
    public function __construct() 
    {
        $this->setEnable(false);
    }

    /**
     * Get enable
     * 
     * @return boolean
     */
    public function getEnable() 
    {
        return $this->enable;
    }

    /**
     * Set enable 
     * 
     * @param boolean $enable
     * @return $this
     */
    public function setEnable($enable) 
    {
        $this->enable = $enable;
        
        return $this;
    }
}

