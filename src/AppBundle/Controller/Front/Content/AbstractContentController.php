<?php

namespace AppBundle\Controller\Front\Content;

use AppBundle\Controller\Controller as BaseController;

/**
 * Description of AbstractContentController
 *
 * @author Hubsine <contact@hubsine.com>
 */
abstract class AbstractContentController extends BaseController
{
    /**
     * Get offres from OffreDomain
     * 
     * @param array $offreDomains
     * @param string $slug
     * @return array
     */
    protected function getOffresByOffreDomain(array $offreDomains, $slug)
    {
        foreach ($offreDomains as $category)
        {
            if( $category->getSlug() === $slug )
            {
                return $category->getOffres();
            }
        }
        
        return [];
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
