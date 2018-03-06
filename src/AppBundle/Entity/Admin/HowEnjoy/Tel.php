<?php

namespace AppBundle\Entity\Admin\HowEnjoy;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber as AssertPhoneNumber;
use AppBundle\Entity\AdminEntityInterface;
use AppBundle\Entity\Admin\HowEnjoy\AbstractHowEnjoy;

/**
 * Tel
 *
 * @ORM\Table(name="np_how_enjoy_by_tel")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Admin\HowEnjoy\TelRepository")
 */
class Tel extends AbstractHowEnjoy implements AdminEntityInterface
{
    CONST ROUTE_PREFIX = 'how_enjoy_tel';
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     * 
     * @ORM\Column(type="phone_number")
     * 
     * @AssertPhoneNumber(defaultRegion="FR", message="assert.phone.not_phone")
     */
    private $phone;


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
     * Set phone
     *
     * @param string $phone
     *
     * @return Tel
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }
}

