<?php
 
namespace AppBundle\Controller\Front\Content;

use AppBundle\Controller\Front\Content\AbstractContentController;
use AppBundle\Entity\Admin\Category\Company;
use AppBundle\Entity\User\Partner\Offre;
use AppBundle\Entity\Admin\Category\OffreDomain;

/**
 * Description of ContentController
 *
 * @author Hubsine <contact@hubsine.com>
 */
class ContentController extends AbstractContentController
{
    const BASE_VIEW_FOLDER  = '@Front/Content/';
    
    /**
     * @return Response
     */
    public function indexAction()
    {
        $doctrineUtil   = $this->getDoctrineUtil();
        
        $categories = $doctrineUtil->getRepository(OffreDomain::class)->findAllForHomePage();
        $offres     = $doctrineUtil->getRepository(Offre::class)->findAllForHomePage();
        
        return $this->render( self::BASE_VIEW_FOLDER . 'index.html.twig', [
            'categories'    => $categories,
            'offres'        => $offres
        ]);
    }
    
    /**
     * Affichage d'une liste d'offre par catégorie d'offre (OffreDomain)
     * 
     * @param string $slug Slug of OffreDomain
     * @return Response
     */
    public function showSingleCategoryAction($slug)
    {
        $doctrineUtil   = $this->getDoctrineUtil();
        
        $categories     = $doctrineUtil->getRepository(OffreDomain::class)->findAllForHomePage();
        $offres         = $this->getOffresByOffreDomain($categories, $slug);
        
        return $this->render( self::BASE_VIEW_FOLDER . '/Offre/category.html.twig', [
           'categories'     => $categories,
            'offres'        =>  $offres
        ]);
    }
 
    /**
     * Affichage Single offre 
     * 
     * @param type $slug Slug of Offre
     * @return Response 
     */
    public function showSingleOffreAction($slug)
    {
        
        $doctrineUtil   = $this->getDoctrineUtil();
        
        $categories     = $doctrineUtil->getRepository(OffreDomain::class)->findAllForHomePage();
        
        $offres         = $doctrineUtil->getRepository(Offre::class)->findAllForHomePage();
        $offre          = $this->getCurrentOffre($offres, $slug);
        
        return $this->render(self::BASE_VIEW_FOLDER . '/Offre/single.html.twig', [
            'categories'    => $categories,
            'offres'        => [],
            'offre'         => $offre 
        ]);
    }
}
