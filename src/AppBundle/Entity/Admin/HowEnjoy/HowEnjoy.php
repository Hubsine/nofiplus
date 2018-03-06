<?php

namespace AppBundle\Entity\Admin\HowEnjoy;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use AppBundle\Traits\EntityRoutePrefixTrait;
use AppBundle\Entity\AdminEntityInterface;

/**
 *HowEnjoy
 *
 * @ORM\Table(name="np_how_enjoy")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Admin\HowEnjoy\HowEnjoyRepository")
 * 
 * @UniqueEntity(fields="enjoyBy", message="assert.unique_entity.how_enjoy")
 */
class HowEnjoy implements AdminEntityInterface
{
    const ROUTE_PREFIX  = 'how_enjoy';
    
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

