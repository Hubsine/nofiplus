<?php

namespace AppBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use AppBundle\Entity\Media\MediaInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Description of UploadMediaEvent
 *
 * @author Hubsine <contact@hubsine.com>
 */
class UploadMediaEvent extends Event
{
    /**
     * @var array
     */
    private $medias;
    
    /**
     * Constructor
     * 
     * @param array $medias
     */
    public function __construct(array $medias = array()) 
    {
        $this->medias = $medias;
    }
    
    /**
     * Get $medias
     * 
     * @return array
     */
    public function getMedias()
    {
        return $this->medias;
    }
    
    /**
     * Set $medias 
     * 
     * @param array $medias
     */
    public function setMedias(array $medias = array())
    {
        $this->medias = $medias;
    }
}
