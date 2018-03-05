<?php

namespace AppBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\AppBundleEvents;
use AppBundle\Event\FormCollectionEvent;
use AppBundle\Doctrine\DoctrineUtil;

/**
 * Description of FormCollectionSubscriber
 *
 * @author Hubsine <contact@hubsine.com>
 */
class FormCollectionSubscriber implements EventSubscriberInterface
{
    /**
     * @var DoctrineUtil
     */
    private $doctrineUtil;
    
    /**
     * Constructor 
     * 
     * @param DoctrineUtil $doctrineUtil
     */
    public function __construct(DoctrineUtil $doctrineUtil) 
    {
        $this->doctrineUtil = $doctrineUtil;
    }
    
    /**
     * {@inheritdoc}
     * 
     * @return array
     */
    static public function getSubscribedEvents()
    {
        return array(
            AppBundleEvents::FORM_COLLECTION_INITIALIZE     => 'saveOriginalArrayCollection',
            AppBundleEvents::FORM_COLLECTION_SUCCESS        => 'removeArrayCollectionItems',
        );
    }
    
    /**
     * Save original array collection of an entity in new array collection instance 
     * 
     * @param FormCollectionEvent $event
     */
    public function saveOriginalArrayCollection(FormCollectionEvent $event)
    {
        $originalArrayCollection            = $event->getOriginalArrayCollection();
        
        /** 
         * Le backup est nécessaire puisque les objects sont par références, donc il faut créer un nouveau ArrayCollection 
         ***/
        $backupOfOriginalArrayCollection    = new ArrayCollection();
        
        foreach ($originalArrayCollection as $arrayCollectionItem) 
        {
            $backupOfOriginalArrayCollection->add($arrayCollectionItem);
        }
        
        $event->setNewArrayCollection($backupOfOriginalArrayCollection);
    }
    
    /**
     * Remove array collection item 
     * 
     * @param FormCollectionEvent $event
     */
    public function removeArrayCollectionItems(FormCollectionEvent $event)
    {
        $originalArrayCollection        = $event->getOriginalArrayCollection();
        $newArrayCollection             = $event->getNewArrayCollection(); /** by reference **/

        foreach ($originalArrayCollection as $arrayCollectionItem) 
        {
            if (false === $newArrayCollection->contains($arrayCollectionItem)) 
            {
                $originalArrayCollection->removeElement($arrayCollectionItem);
                $this->doctrineUtil->remove($arrayCollectionItem, false);
            }
        }
        
        $event->setNewArrayCollection($originalArrayCollection);
    }
    
}
