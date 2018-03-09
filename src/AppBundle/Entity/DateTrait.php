<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Hubsine <contact@hubsine.com>
 */
trait DateTrait 
{
    /**
     * @var \DateTime
     * 
     * @ORM\Column(name="start", type="datetime")
     * 
     * @Assert\NotBlank(message="assert.not_blank")
     * @Assert\Date(message="assert.date")
     * @Assert\GreaterThanOrEqual("today", message="assert.date.greater_than_or_equal")
     * @Assert\LessThanOrEqual(propertyPath="end", message="assert.date.less_than_or_equal")
     */
    private $start;
    
    /**
     * @var \DateTime
     * 
     * @ORM\Column(name="end", type="datetime")
     * 
     * @Assert\NotBlank(message="assert.not_blank")
     * @Assert\Date(message="assert.date")
     * @Assert\GreaterThanOrEqual(propertyPath="start", message="assert.date.greater_than_or_equal")
     * @Assert\LessThanOrEqual("today", message="assert.date.less_than_or_equal")
     */
    private $end;
    
    /**
     * Get Date start
     * 
     * @return \DateTime
     */
    public function getStart(): \DateTime 
    {
        return $this->start;
    }

    /**
     * Get Date End
     * 
     * @return \DateTime
     */
    public function getEnd(): \DateTime 
    {
        return $this->end;
    }

    /**
     * Set date start
     * 
     * @param \DateTime $start
     */
    public function setStart(\DateTime $start) 
    {
        $this->start = $start;
    }

    /**
     * Set date end
     * 
     * @param \DateTime $end
     */
    public function setEnd(\DateTime $end) 
    {
        $this->end = $end;
    }
}
