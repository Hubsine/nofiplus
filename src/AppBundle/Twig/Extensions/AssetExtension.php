<?php

namespace AppBundle\Twig\Extensions;

use AppBundle\Entity\User\Avatar;
use AppBundle\Util\MediaUtil;
use AppBundle\Entity\Media\MediaInterface;

/**
 * Description of AssetExtension
 *
 * @author Hubsine <contact@hubsine.com>
 */
class AssetExtension extends \Twig_Extension
{
    const DEFAULT_AVATAR = 'build/images/default_avatar.png';
    
    /**
     * @var MediaUtil $mediaUtil
     */
    private $mediaUtil;
    
    /**
     * Constructor
     * 
     * @param MediaUtil $mediaUtil
     */
    public function __construct(MediaUtil $mediaUtil) 
    {
        $this->mediaUtil = $mediaUtil;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('holderJs', array($this, 'holderJs')),
            new \Twig_SimpleFunction('getAvatar', array($this, 'getAvatar'))
        );
    }
    
    /**
     * Holder js 
     * 
     * @param string $size
     * @param array $options
     * 
     * @return string
     */
    public function holderJs($size, $options = array())
    {
        $dataSrc = 'data-src=holder.js/' . $size;
        
        if( !empty($options) )
        {
            $dataSrc .= '?';
        }
            
        foreach ($options as $key => $value) 
        {
            $dataSrc .= $key . '=' . $value . '&';
        }
        
        return $dataSrc;
    }
    
    /**
     * Get Avatar
     * 
     * @param MediaInterface|null $media
     * 
     * @return string
     */
    public function getAvatar(MediaInterface $media = null)
    {
        return ( ! $media instanceof Avatar ) ? self::DEFAULT_AVATAR : $this->mediaUtil->getWebUrl($media);
    }
}
