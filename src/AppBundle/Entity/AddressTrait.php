<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 * @author Hubsine <contact@hubsine.com>
 */
trait AddressTrait 
{
    /**
     * @var string
     * 
     * @ORM\OneToOne(targetEntity="\AppBundle\Entity\Address", cascade={"persist", "remove"})
     * 
     * @Assert\Type(type="\AppBundle\Entity\Address")
     * @Assert\Valid()
     */
    private $address;
    
    /**
     * Set address
     *
     * @param \AppBundle\Entity\Addres $address
     *
     * @return mixed
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return \AppBundle\Entity\Addres
     */
    public function getAddress()
    {
        return $this->address;
    }
}
