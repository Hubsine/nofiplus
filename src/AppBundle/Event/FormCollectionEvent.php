<?php

namespace AppBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Doctrine\Common\Collections\Collection as DoctrineArrayCollectionInterface;

/**
 * Description of FormCollectionEvent
 *
 * @author Hubsine <contact@hubsine.com>
 */
class FormCollectionEvent extends Event
{
    /**
     * @var DoctrineArrayCollectionInterface Is not by reference, it's a backup of orignal array collection 
     */
    private $originalArrayCollection;
    
    /**
     * @var DoctrineArrayCollectionInterface This collection is by reference to update entity array collection
     */
    private $newArrayCollection;
    
    /**
     * Constructor 
     * 
     * @param DoctrineArrayCollectionInterface $originalArrayCollection
     * @param DoctrineArrayCollectionInterface $newArrayCollection
     */
    public function __construct(DoctrineArrayCollectionInterface $originalArrayCollection, DoctrineArrayCollectionInterface $newArrayCollection) 
    {
        $this->originalArrayCollection  = $originalArrayCollection;
        $this->newArrayCollection       = $newArrayCollection;
    }
    
    /**
     * Get original array collection 
     * 
     * @return DoctrineArrayCollectionInterface
     */
    public function getOriginalArrayCollection()
    {
        return $this->originalArrayCollection;
    }
    
    /**
     * Set original array collection 
     * 
     * @param DoctrineArrayCollectionInterface $arrayCollection
     */
    public function setOriginalArrayCollection(DoctrineArrayCollectionInterface $arrayCollection)
    {
        $this->originalCollection   = $arrayCollection;
    }
    
    /**
     * Get new array collection bind from form 
     * 
     * @return DoctrineArrayCollectionInterface
     */
    public function getNewArrayCollection()
    {
        return $this->newArrayCollection;
    }

    /**
     * Set new array collection 
     * 
     * @param DoctrineArrayCollectionInterface $newArrayCollection
     */
    public function setNewArrayCollection(DoctrineArrayCollectionInterface $newArrayCollection) 
    {
        $this->newArrayCollection = $newArrayCollection;
    }
}
