<?php
 
namespace AppBundle\Controller\Front\Pages;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use AppBundle\Controller\Front\Pages\AbstractPagesController;
use AppBundle\Entity\Admin\Pages\Page;
use AppBundle\Entity\Contact;
use AppBundle\Form\Type\ContactType;
use AppBundle\Exception\BadInstanceException;

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
        $pages          = $request->attributes->get('pages');
        $parameters     = ['page'   => null];
        
        foreach ($pages as $page) 
        {
            if( $page->getSlug() === $slug )
            {
                $parameters['page'] = $page;
                break;
            }
        }
        
        if( ! $page instanceof Page )
        {
            throw new BadInstanceException($page, Page::class);
        }
        
        
        if( $page->getUniqueStringId() === 'contact' )
        {
            $parameters['form'] = $this->createContactForm($request);
            
            if( $parameters['form'] instanceof RedirectResponse )
            {
                return $parameters['form'];
            }
            
            $parameters['form'] = $parameters['form']->createView();
        }
        
        return $this->render( self::BASE_VIEW_FOLDER . 'index.html.twig', $parameters);
    }
    
    protected function createContactForm(Request $request)
    {
        $form   = $this->createForm(ContactType::class, $contact = new Contact());
        
        $form->handleRequest($request);
        
        if( $form->isSubmitted() && $form->isValid() )
        {
            $this->getDoctrineUtil()->persist($contact);
            
            $this->addFlash('success', 'flash.contact.success');
            
            $this->get('app.mailer.twig_swift_mailer')->sendContactMessage($contact);
            
            return $this->redirect($request->headers->get('referer'));
        }
        
        return $form;
    }
    
}
