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
        $this->isGrantedWithDeny('VIEW', $partner);
        
        // replace this example code with whatever you need
        return $this->render('@Front/User/Profile/Partner/Compagny/index.html.twig', [
            'partner'   => $partner,
            'compagnies' => $this->getCompagniesFromPartner($partner)
        ]);
    }
    
    /**
     * @ParamConverter("partner", options={"mapping": {"partner": "slug"}})
     * 
     * @param Request $request
     * @param Partner $partner
     * @return Response
     */
    public function showAction(Request $request, Partner $partner, Compagny $compagny)
    {
        $this->isGrantedWithDeny('VIEW', $compagny);
        
        $compagnies = $this->getCompagniesFromPartner($partner);
        
        // replace this example code with whatever you need
        return $this->render('@Front/User/Profile/Partner/Compagny/show.html.twig', [
            'partner'  => $partner, 
            'currentCompagny'  => $compagny,
            'compagnies' => $compagnies
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
        return $this->render('@Front/User/Profile/Partner/Compagny/new.html.twig', [
            'partner'  => $partner, 
            'form'  => $form->createView(),
            'currentCompagny'   => $compagny,
            'compagnies'    => $this->getCompagniesFromPartner($partner)
        ]);
    }
    
    /**
     * @ParamConverter("partner", options={"mapping": {"partner": "slug"}})
     * 
     * @param Request $request
     * @param Partner $partner
     * @return Response
     * @throws AccessDeniedException
     */
    public function updateAction(Request $request, Partner $partner, Compagny $compagny)
    {
        $this->isGrantedWithDeny('EDIT', $compagny);
        
        $compagnies = $this->getCompagniesFromPartner($partner);
                
        $form   = $this->createForm( CompagnyType::class, $compagny, ['validation_groups'=> ['Default'], 'action'   => 'update'] );
        
        $form->handleRequest($request);
        
        if( $form->isSubmitted() && $form->isValid() )
        {
            $this->getDoctrineUtil()->merge($compagny);
            
            $this->addFlash('success', 'flash.update_success');
            
            return $this->redirectToRoute(
                $this->getRouteUtil()->getCompleteRoute(Compagny::class, 'index'),
                ['partner' => $partner->getSlug()]
            );
        }
        
        // replace this example code with whatever you need
        return $this->render('@Front/User/Profile/Partner/Compagny/update.html.twig', [
            'partner'  => $partner, 
            'form'  => $form->createView(),
            'currentCompagny'   => $compagny,
            'compagnies'    => $compagnies
        ]);
    }
    
    /**
     * @ParamConverter("partner", options={"mapping": {"partner": "slug"}})
     * 
     * @param Request $request
     * @param Partner $partner
     * @param Compagny $compagny
     * @return Response
     */
    public function deleteAction(Request $request, Partner $partner, Compagny $compagny)
    {
        $this->isGrantedWithDeny('DELETE', $compagny);
        $this->checkDeleteToken();
        
        $this->getDoctrineUtil()->remove($compagny);
            
        $this->addFlash('success', 'flash.delete_success');
            
        return $this->redirectToRoute(
            $this->getRouteUtil()->getCompleteRoute(Compagny::class, 'index'),
            ['partner' => $partner->getSlug()]
        );
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
    
    /**
     * 
     * @param Partner $partner
     * @return array[Compagny]
     */
    private function getCompagniesFromPartner(Partner $partner)
    {
        return $this->getDoctrineUtil()->getRepository(Compagny::class)->findAllByPartnerWithJoin($partner);
    }
}
