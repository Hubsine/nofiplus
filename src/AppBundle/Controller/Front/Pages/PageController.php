<?php
 
namespace AppBundle\Controller\Front\Pages;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\Front\Pages\AbstractPagesController;

/**
 * Description of PageController
 *
 * @author Hubsine <contact@hubsine.com>
 */
class PageController extends AbstractPagesController
{
    const BASE_VIEW_FOLDER  = '@Front/Pages/Page/';
    
    /**
     * @return Response
     */
    public function indexAction(Request $request, $slug)
    {
        $pages  = $request->attributes->get('pages');
        
        foreach ($pages as $page) 
        {
            if( $page->getSlug() === $slug )
            {
                return $this->render( self::BASE_VIEW_FOLDER . 'index.html.twig', [
                    'page'  => $page
                ]);
            }
        }
    }
}
