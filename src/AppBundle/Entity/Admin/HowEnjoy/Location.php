<?php

namespace AppBundle\Entity\Admin\HowEnjoy;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\AddressTrait;
use AppBundle\Entity\AdminEntityInterface;
use AppBundle\Entity\Admin\HowEnjoy\AbstractHowEnjoy;

/**
 * Location
 *
 * @ORM\Table(name="np_how_enjoy_by_location")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Admin\HowEnjoy\LocationRepository")
 */
class Location extends AbstractHowEnjoy implements AdminEntityInterface
{
    CONST ROUTE_PREFIX = 'how_enjoy_location';
    
    use AddressTrait;
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

}

