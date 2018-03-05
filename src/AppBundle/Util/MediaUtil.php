<?php

namespace AppBundle\Util;

use Stof\DoctrineExtensionsBundle\Uploadable\UploadableManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use AppBundle\Entity\Media\MediaInterface;

/**
 * Description of MediaUtil
 *
 * @author Hubsine <contact@hubsine.com>
 */
class MediaUtil 
{
    /**
     * @var \UploadableManager
     */
    private $uploadableManager;
    
    /**
     * @var string
     */
    private $webPath;
    
    /**
     * Constructor 
     * 
     * @param string $webPath
     */
    public function __construct(UploadableManager $uploadableManager, $webPath) 
    {
        $this->uploadableManager    = $uploadableManager;
        $this->webPath              = $webPath;
    }
    
    /**
     * Get a uploaded file web url
     * 
     * @param MediaInterface $media
     * @return string
     */
    public function getWebUrl(MediaInterface $media)
    { 
        return '/' . $media->getPath() . '/' . $media->getName();
    }
    
    /**
     * Get web path 
     * 
     * @return string
     */
    public function getWebPath()
    {
        return $this->webPath;
    }
    
    /**
     * Get file a path 
     * 
     * @param MediaInterface $media
     * @return string File path
     */
    public function getFilePath(MediaInterface $media)
    {
        return $this->getWebPath() . $this->getWebUrl($media);
    }

    /**
     * Remove a file 
     * 
     * @param string $filePath
     * @return boolean
     */
    public function removeFile($filePath)
    {
        if (is_file($filePath)) {
            return @unlink($filePath);
        }

        return false;
    }
    
    /**
     * Check if file upload is an instance of UploadedFile 
     * 
     * @param mixed $media
     * @return boolean
     */
    public function isUploadedFile($media)
    {
        if( ! $media instanceof MediaInterface )
        {
            return false;
        }
        
        return $media->getFile() instanceof UploadedFile;
    }

    /**
     * Mark an media entity to upload
     * 
     * @param MediaInterface $media
     */
    public function markEntityToUpload(MediaInterface $media)
    {
        $media->setPath( $this->webPath . '/' . $media->getPath() );
        
        $this->uploadableManager->markEntityToUpload($media, $media->getFile());
    }
}
