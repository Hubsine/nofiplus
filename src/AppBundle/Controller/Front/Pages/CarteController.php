<?php
 
namespace AppBundle\Controller\Front\Pages;

use AppBundle\Controller\Front\Pages\AbstractPagesController;
use AppBundle\Entity\Admin\Category\Carte;

/**
 * Description of CarteController
 *
 * @author Hubsine <contact@hubsine.com>
 */
class CarteController extends AbstractPagesController
{
    const BASE_VIEW_FOLDER  = '@Front/Pages/Carte/';
    
    /**
     * @return Response
     */
    public function indexAction()
    {
        $cartes = $this->getDoctrineUtil()->getRepository(Carte::class)->findAll();
        
        return $this->render( self::BASE_VIEW_FOLDER . 'index.html.twig', [
            'cartes'    => $cartes
        ]);
    }
}
