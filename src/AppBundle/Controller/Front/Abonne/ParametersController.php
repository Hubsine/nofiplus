<?php

namespace AppBundle\Controller\Front\Abonne;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use AppBundle\Controller\Controller;
use AppBundle\Controller\Front\Abonne\AbonneController;
use AppBundle\Entity\User\Abonne\Abonne;
use AppBundle\Form\Type\User\Partner\ParametersType;

class ParametersController extends Controller
{
    
    /**
     * @ParamConverter("abonne", class="AppBundle:User\Abonne\Abonne", options={"repository_method" = "findOneForShow"})
     * 
     * @param Request $request
     * @return Response
     * @throws AccessDeniedException
     */
    public function updateAction(Request $request, Abonne $abonne)
    {
        $this->isGrantedWithDeny('EDIT', $abonne);
       
        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->getEventDispatcher();
        
        $event = new GetResponseUserEvent($abonne, $request);
        $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }
        
        $form = $this->createForm(ParametersType::class, $abonne);
        $form->setData($abonne);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) 
        {
            
            $event = new FormEvent($form, $request);
            
            $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_SUCCESS, $event);
            
            $this->getDoctrineUtil()->persist($abonne);
            
            if ( null === $response = $event->getResponse() ) 
            {
                $response = $this->redirectToRoute(
                    $this->getRouteUtil()->getCompleteRoute(Partner::class, 'index'), 
                    ['abonne'    => $abonne->getSlug()]
                );
            }
            
            $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_COMPLETED, new FilterUserResponseEvent($abonne, $request, $response));
            
            return $response;
        }
        
        return $this->render(AbonneController::BASE_VIEW_FOLDER . 'update_parameters.html.twig', array(
            'form'  => $form->createView(),
            'abonne'  => $abonne
        ));
    }
}
