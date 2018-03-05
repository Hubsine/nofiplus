<?php

namespace AppBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use AppBundle\Event\UploadMediaEvent;
use AppBundle\Entity\Media\MediaInterface;
use AppBundle\Util\MediaUtil;
use AppBundle\AppBundleEvents;

/**
 * Description of UploadMediaSubscriber
 *
 * @author Hubsine <contact@hubsine.com>
 */
class UploadMediaSubscriber implements EventSubscriberInterface
{
    /**
     * @var \AppBundle\Util\MediaUtil
     */
    private $mediaUtil;
    
    /**
     * @var array
     */
    private $medias;
    
    /**
     * Constructor 
     * 
     * @param \AppBundle\Util\MediaUtil $mediaUtil
     */
    public function __construct(MediaUtil $mediaUtil) 
    {
        $this->mediaUtil = $mediaUtil;
        
        $this->medias = array();
    }
    
    /**
     * {@inheritdoc}
     * 
     * @return array
     */
    static public function getSubscribedEvents()
    {
        return array(
            AppBundleEvents::UPLOAD_MEDIA_INITIALIZE    => 'processUploadInitialize',
            AppBundleEvents::UPLOAD_MEDIA_COMPLETED    => 'processRemoveFile'
        );
    }
  
    /**
     * Add a MediaInterface entity to remove after
     * 
     * @param UploadMediaEvent $event
     */
    public function processUploadInitialize(UploadMediaEvent $event)
    {
        $medias = $event->getMedias();
        
        foreach ($medias as $media) 
        {
            $this->addMedia($media);           
        }
        
        $event->setMedias();
    }
    
    /**
     * Remove a old file 
     *
     * @param \AppBundle\Event\UploadMediaEvent $event
     */
    public function processRemoveFile(UploadMediaEvent $event)
    {
        foreach ($this->medias as $media) 
        {
            $this->mediaUtil->removeFile($media);
        }
        
        $event->setMedias();
    }
    
    /**
     * Add a MediaInterface object in array Collection
     * 
     * @param MediaInterface $media
     */
    protected function addMedia(MediaInterface $media)
    {
        $this->medias[] = $this->mediaUtil->getFilePath($media);
    }
}
