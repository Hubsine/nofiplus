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
use AppBundle\Form\Type\User\Partner\PartnerType;

class PartnerController extends Controller
{
    
    /**
     * @return Response
     */
    public function indexAction()
    {
        $partner    = $this->getDoctrineUtil()->getRepository(Partner::class)->findOneForIndex( $this->getUser()->getId() );
        
        $this->isGrantedWithDeny('EDIT', $partner);
        
        // replace this example code with whatever you need
        return $this->render('@Front/User/Profile/Partner/index.html.twig', [
        ]);
    }
    
    /**
     * @return Response
     */
    public function showAction()
    {
        $partner    = $this->getDoctrineUtil()->getRepository(Partner::class)->findOneForIndex( $this->getUser()->getId() );
        $this->isGrantedWithDeny('EDIT', $partner);
        
        // replace this example code with whatever you need
        return $this->render('@Front/User/Profile/Partner/show.html.twig', [
            'user'  => $partner
        ]);
    }
    
    /**
     * @param Request $request
     * @return Response
     * @throws AccessDeniedException
     */
    public function updateAction(Request $request)
    {
        $partner    = $this->getDoctrineUtil()->getRepository(Partner::class)->findOneForIndex( $this->getUser()->getId() );
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
        
        $lastUsername   = $partner->getUsername();

        $form = $this->createForm(PartnerType::class, $partner);
        $form->setData($partner);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) 
        {
            
            $event = new FormEvent($form, $request);
            
            $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_SUCCESS, $event);
            
            $this->getDoctrineUtil()->persist($partner);
            
            // Update Acl if username is changed
            $this->getAclManager()->updateUserSecurityIdentity($partner, $lastUsername);
            
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
        
        return $this->render('@Front/User/Profile/Partner/update.html.twig', array(
            'form'  => $form->createView(),
            'partner'  => $partner
        ));
    }
    
    /**
     * Check if is Partner object instance
     * 
     * @param Partner $partner
     * @throws AccessDeniedException
     */
    public static function isPartner($partner)
    {
        if ( ! is_object($partner) || !$partner instanceof Partner ) 
        {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
    }
}
