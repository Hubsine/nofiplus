<?php

namespace AppBundle\Controller\Front\Abonne;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use AppBundle\Controller\Controller;
use AppBundle\Entity\User\Abonne\Abonne;
use AppBundle\Form\Type\User\Abonne\AbonneType;

class AbonneController extends Controller
{
    const BASE_VIEW_FOLDER   = '@Front/User/Profile/Abonne/';
    
    /**
     * @ParamConverter("abonne", class="AppBundle:User\Abonne\Abonne", options={"repository_method" = "findOneForShow"})
     * 
     * @return Response
     */
    public function showAction($abonne)
    {
        $this->isGrantedWithDeny('EDIT', $abonne);
        
        // replace this example code with whatever you need
        return $this->render(self::BASE_VIEW_FOLDER . 'show.html.twig', [
            'user'  => $abonne
        ]);
    }
    
    /**
     * @ParamConverter("abonne", class="AppBundle:User\Abonne\Abonne", options={"repository_method" = "findOneForUpdate"})
     * 
     * @param Request $request
     * @return Response
     * @throws AccessDeniedException
     */
    public function updateAction(Request $request, $abonne)
    {
        $this->isGrantedWithDeny('EDIT', $abonne);
       
        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->getEventDispatcher();
        
        $event = new GetResponseUserEvent($abonne, $request);
        $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }
        
        $lastUsername   = $abonne->getUsername();

        $form = $this->createForm(AbonneType::class, $abonne);
        $form->setData($abonne);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) 
        {
            
            $event = new FormEvent($form, $request);
            
            $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_SUCCESS, $event);
            
            $this->getDoctrineUtil()->persist($abonne);
            
            // Update Acl if username is changed
            $this->getAclManager()->updateUserSecurityIdentity($abonne, $lastUsername);
            
            if ( null === $response = $event->getResponse() ) 
            {
                $response = $this->redirectToRoute(
                    $this->getRouteUtil()->getCompleteRoute(Abonne::class, 'index'), 
                    ['abonne'    => $abonne->getSlug()]
                );
            }
            
            $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_COMPLETED, new FilterUserResponseEvent($abonne, $request, $response));
            
            return $response;
        }
        
        return $this->render( self::BASE_VIEW_FOLDER . 'update.html.twig', array(
            'form'  => $form->createView(),
            'user'  => $abonne
        ));
    }
}
