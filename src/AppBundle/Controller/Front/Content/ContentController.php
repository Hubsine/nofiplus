<?php
 
namespace AppBundle\Controller\Front\Content;

use AppBundle\Controller\Front\Content\AbstractContentController;
use AppBundle\Entity\Admin\Category\Company;
use AppBundle\Entity\User\Partner\Offre;

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
        
        $categories = $doctrineUtil->getRepository(Company::class)->findAll();
        $offres     = $doctrineUtil->getRepository(Offre::class)->findAll();
        
        return $this->render( self::BASE_VIEW_FOLDER . 'index.html.twig', [
            'categories'    => $categories,
            'offres'        => $offres
        ]);
    }
}
