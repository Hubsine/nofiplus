<?php

namespace AppBundle\Controller\Front\Content;

use AppBundle\Controller\Controller as BaseController;
use AppBundle\Entity\Admin\Category\OffreDomain;

/**
 * Description of AbstractContentController
 *
 * @author Hubsine <contact@hubsine.com>
 */
abstract class AbstractContentController extends BaseController
{
    /**
     * Get current OffreDomain
     * 
     * @param array $offreDomains
     * @param string $slug
     * @return OffreDomaine|null
     */
    protected function getCurrentOffreDomain(array $offreDomains, $slug)
    {
        foreach ($offreDomains as $category)
        {
            if( $category->getSlug() === $slug )
            {
                return $category;
            }
        }
        
        return null;
    }
    
    /**
     * Get current offre 
     * 
     * @param array $offres
     * @param string $slug
     * @return array
     */
    protected function getCurrentOffre(array $offres, $slug)
    {
        foreach ($offres as $offre)
        {
            if( $offre->getSlug() === $slug )
            {
                return $offre;
            }
        }
        
        return [];
    }
}
