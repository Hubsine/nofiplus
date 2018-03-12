<?php

namespace AppBundle\Controller\Front\Partner;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use AppBundle\Controller\Controller;
use AppBundle\Entity\User\Partner\Partner;
use AppBundle\Entity\User\Partner\Compagny;
use AppBundle\Form\Type\User\Partner\CompagnyType;

class CompagnyController extends Controller
{
    /**
     * @ParamConverter("partner", options={"mapping": {"partner": "slug"}})
     * 
     * @param Request $request
     * @param Partner $partner
     * @return type
     */
    public function indexAction(Request $request, Partner $partner)
    {
        // replace this example code with whatever you need
        return $this->render('@Front/User/Profile/Partner/Compagny/index.html.twig', [
            'partner'   => $partner
        ]);
    }
    
    /**
     * @ParamConverter("partner", options={"mapping": {"partner": "slug"}})
     * 
     * @param Request $request
     * @param Partner $partner
     * @return Response
     */
    public function newAction(Request $request, Partner $partner)
    {
        $this->isPartner($partner);
        
        $form   = $this->createForm( CompagnyType::class, $compagny = new Compagny() );
        
        $compagny->setPartner($partner);

        $form->handleRequest($request);
        
        if( $form->isSubmitted() && $form->isValid() )
        {
            $this->getDoctrineUtil()->persist($compagny);
            
            $maskBuilder    = $this->getAclManager()->getMaskBuilder(MaskBuilder::MASK_OPERATOR);
            
            $this->getAclManager()->insertObjectAce($compagny, $maskBuilder);
            $this->getAclManager()->insertObjectAce($compagny->getAddress(), $maskBuilder);
            $this->getAclManager()->insertObjectAce($compagny->getLogo(), $maskBuilder);
            
            $this->addFlash('success', 'flash.add_success');
            
            return $this->redirectToRoute(
                    $this->getRouteUtil()->getCompleteRoute(Compagny::class, 'index'),
                    ['partner' => $partner->getSlug()]
                );
        }
        
        // replace this example code with whatever you need
        return $this->render('@Front/User/Profile/Partner/Compagny/index.html.twig', [
            'partner'  => $partner, 
            'form'  => $form->createView(),
            'action'    => 'new'
        ]);
    }
    
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
        
        return $this->render('@Front/User/Profile/Partner/edit.html.twig', array(
            'form'  => $form->createView(),
            'partner'  => $partner
        ));
    }
    
    /**
     * Check is Partner object instance
     * 
     * @param Partner $partner
     * @throws AccessDeniedException
     */
    private function isPartner($partner)
    {
        if ( ! is_object($partner) || !$partner instanceof Partner ) 
        {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
    }
}
