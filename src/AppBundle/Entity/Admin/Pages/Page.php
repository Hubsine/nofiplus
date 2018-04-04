<?php

namespace AppBundle\Entity\Admin\Pages;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use AppBundle\Entity\EntityInterface;
use AppBundle\Entity\AdminEntityInterface;
use AppBundle\Traits\DoctrineTrait;
use AppBundle\Traits\EntityRoutePrefixTrait;
use AppBundle\Entity\Admin\Pages\PageTrait;

/**
 * Page
 *
 * @ORM\Table(name="np_pages_page")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Admin\Pages\PageRepository")
 * 
 * @UniqueEntity("uniqueStringId", message="assert.unique_entity.unique_string_id")
 * 
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 */
class Page implements EntityInterface, AdminEntityInterface, Translatable
{
    const ROUTE_PREFIX  = 'pages';
    
    use DoctrineTrait;
    use EntityRoutePrefixTrait;
    use PageTrait;
    
    /**
     * @var string
     *
     * @Gedmo\Translatable
     * 
     * @ORM\Column(name="label", type="string", length=255)
     * 
     * @Assert\NotBlank(message="assert.not_blank")
     * @Assert\Type(type="string", message="assert.type")
     */
    private $label;
    
    /**
     * @var string
     *
     * @ORM\Column(name="uniqueStringId", type="string", length=25, unique=true, nullable=true)
     * 
     * @Assert\Choice(callback="getUniqueStringIds", message="assert.choice")
     */
    private $uniqueStringId;
    
    public static function getUniqueStringIds()
    {
        return ['contact', 'cgv', 'mentions-legales'];
    }

    /**
     * Set label
     *
     * @param string $label
     *
     * @return Menu
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set uniqueStringId
     *
     * @param string $uniqueStringId
     *
     * @return Menu
     */
    public function setUniqueStringId($uniqueStringId)
    {
        $this->uniqueStringId = $uniqueStringId;

        return $this;
    }

    /**
     * Get uniqueStringId
     *
     * @return string
     */
    public function getUniqueStringId()
    {
        return $this->uniqueStringId;
    }
}

