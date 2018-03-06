<?php

namespace AppBundle\Entity\Admin\HowEnjoy;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use AppBundle\Traits\EntityRoutePrefixTrait;

/**
 * AbstractHowEnjoy
 *
 * @ORM\Entity
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({
 *  "location" = "Location", 
 *  "web" = "Web",
 *  "tel" = "Tel"
 * })
 * 
 * @UniqueEntity(fields="enjoyBy", message="assert.unique_entity.how_enjoy")
 */
abstract class AbstractHowEnjoy
{
    use EntityRoutePrefixTrait;
    
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
     * @ORM\Column(name="enjoyBy", type="string", length=30, unique=true)
     * 
     * @Assert\Choice(callback="getEnjoyBys")
     * 
     */
    private $enjoyBy;

    public static function getEnjoyBys()
    {
        return array('location', 'web', 'tel');
    }

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
     * Set enjoyBy
     *
     * @param string $enjoyBy
     *
     * @return HowEnjoy
     */
    public function setEnjoyBy($enjoyBy)
    {
        $this->enjoyBy = $enjoyBy;

        return $this;
    }

    /**
     * Get enjoyBy
     *
     * @return string
     */
    public function getEnjoyBy()
    {
        return $this->enjoyBy;
    }
}

