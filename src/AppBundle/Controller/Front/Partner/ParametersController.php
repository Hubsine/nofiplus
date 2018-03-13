<?php

namespace AppBundle\Controller\Front\Partner;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use AppBundle\Controller\Controller;
use AppBundle\Entity\User\Partner\Partner;
use AppBundle\Form\Type\User\Partner\ParametersType;

class ParametersController extends Controller
{
    /**
     * @ParamConverter("partner", options={"mapping": {"partner": "slug"}})
     * 
     * @param Request $request
     * @param Partner $partner
     * @return Response
     * @throws AccessDeniedException
     */
    public function updateAction(Request $request, Partner $partner)
    {
        $this->isGrantedWithDeny('EDIT', $partner);
       
        if ( ! is_object($partner) || !$partner instanceof Partner ) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        
        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->getEventDispatcher();
        
        $event = new GetResponseUserEvent($partner, $request);
        $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }
        
        $form = $this->createForm(ParametersType::class, $partner);
        $form->setData($partner);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) 
        {
            
            $event = new FormEvent($form, $request);
            
            $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_SUCCESS, $event);
            
            $this->getDoctrineUtil()->persist($partner);
            
            if ( null === $response = $event->getResponse() ) 
            {
                $response = $this->redirectToRoute(
                    $this->getRouteUtil()->getCompleteRoute(Partner::class, 'index'), 
                    ['slug'    => $partner->getSlug()]
                );
            }
            
            $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_COMPLETED, new FilterUserResponseEvent($partner, $request, $response));
            
            return $response;
        }
        
        return $this->render('@Front/User/Profile/Partner/update_parameters.html.twig', array(
            'form'  => $form->createView(),
            'partner'  => $partner
        ));
    }
}
