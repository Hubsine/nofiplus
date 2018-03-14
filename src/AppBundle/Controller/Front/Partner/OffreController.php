<?php

namespace AppBundle\Controller\Front\Partner;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use AppBundle\Controller\Controller;
use AppBundle\Entity\User\Partner\Partner;
use AppBundle\Entity\User\Partner\Compagny;
use AppBundle\Entity\User\Partner\Offre;
use AppBundle\Form\Type\User\Partner\OffreType;

class OffreController extends Controller
{
    /**
     * @ParamConverter("partner", options={"mapping": {"partner": "slug"}})
     * 
     * @param Request $request
     * @param Partner $partner
     * @return type
     */
    public function indexAction(Request $request)
    {
        $this->isGrantedWithDeny('VIEW', $partner);
        
        // replace this example code with whatever you need
        return $this->render('@Front/User/Profile/Partner/Offre/index.html.twig', [
            'partner'   => $partner
            #'compagnies' => $this->getCompagniesFromPartner($partner)
        ]);
    }
    
    /**
     * @ParamConverter("partner", options={"mapping": {"partner": "slug"}})
     * 
     * @param Request $request
     * @param Partner $partner
     * @return Response
     */
//    public function showAction(Request $request, Partner $partner, Offre $offre)
//    {
//        $this->isGrantedWithDeny('VIEW', $offre);
//        
//        $compagnies = $this->getCompagniesFromPartner($partner);
//        
//        // replace this example code with whatever you need
//        return $this->render('@Front/User/Profile/Partner/Offre/show.html.twig', [
//            'partner'  => $partner, 
//            'currentOffre'  => $offre,
//            'compagnies' => $compagnies
//        ]);
//    }
    
    /**
     * @ParamConverter("partner", options={"mapping": {"partner": "slug"}})
     * @ParamConverter("compagny", options={"mapping": {"compagny": "slug"}})
     * 
     * @param Request $request
     * @param Partner $partner
     * @param Compagny $compagny 
     * @return Response
     */
    public function newAction(Request $request, Partner $partner, Compagny $compagny)
    {
        $form   = $this->createForm( OffreType::class, $offre = new Offre() );
        
        $offre->setCompagny($compagny);

        $form->handleRequest($request);
        
        if( $form->isSubmitted() && $form->isValid() )
        {
            $this->getDoctrineUtil()->persist($offre);
            
            $maskBuilder    = $this->getAclManager()->getMaskBuilder(MaskBuilder::MASK_OPERATOR);
            
            $this->getAclManager()->insertObjectAce($offre, $maskBuilder);
            $this->getAclManager()->insertObjectAce($offre->getFeatured(), $maskBuilder);
            
            $this->addFlash('success', 'flash.add_success');
            
            return $this->redirectToRoute(
                    $this->getRouteUtil()->getCompleteRoute(Compagny::class, 'show'),
                    ['partner' => $partner->getSlug(), 'slug'   => $compagny->getSlug()]
                );
        }
        
        // replace this example code with whatever you need
        return $this->render('@Front/User/Profile/Partner/Offre/new.html.twig', [
            'partner'  => $partner, 
            'form'  => $form->createView(),
            'currentOffre'   => $offre,
            'compagnies'    => $this->getCompagniesFromPartner($partner)
        ]);
    }
    
    /**
     * @ParamConverter("partner", options={"mapping": {"partner": "slug"}})
     * @ParamConverter("compagny", options={"mapping": {"compagny": "slug"}})
     * 
     * @param Request $request
     * @param Partner $partner
     * @param Compagny $compagny 
     * @return Response
     * @throws AccessDeniedException
     */
    public function updateAction(Request $request, Partner $partner, Compagny $compagny, Offre $offre)
    {
        $this->isGrantedWithDeny('EDIT', $offre);
        
        $compagnies = $this->getCompagniesFromPartner($partner);
                
        $form   = $this->createForm( OffreType::class, $offre, ['action'   => 'update']);
        
        $form->handleRequest($request);
        
        if( $form->isSubmitted() && $form->isValid() )
        {
            $this->getDoctrineUtil()->merge($offre);
            
            $this->addFlash('success', 'flash.update_success');
            
            return $this->redirectToRoute(
                $this->getRouteUtil()->getCompleteRoute(Compagny::class, 'show'),
                ['partner' => $partner->getSlug(), 'slug'   => $compagny->getSlug()]
            );
        }
        
        // replace this example code with whatever you need
        return $this->render('@Front/User/Profile/Partner/Offre/update.html.twig', [
            'partner'  => $partner, 
            'form'  => $form->createView(),
            'currentOffre'   => $offre,
            'compagnies'    => $compagnies
        ]);
    }
    
    /**
     * @ParamConverter("partner", options={"mapping": {"partner": "slug"}})
     * @ParamConverter("compagny", options={"mapping": {"compagny": "slug"}})
     * 
     * @param Request $request
     * @param Partner $partner
     * @param Compagny $compagny 
     * @param Offre $offre
     * @return Response
     */
    public function deleteAction(Request $request, Partner $partner, Compagny $compagny, Offre $offre)
    {
        $this->isGrantedWithDeny('DELETE', $offre);
        $this->checkDeleteToken();
        
        $this->getDoctrineUtil()->remove($offre);
            
        $this->addFlash('success', 'flash.delete_success');
            
        return $this->redirectToRoute(
            $this->getRouteUtil()->getCompleteRoute(Compagny::class, 'show'),
            ['partner' => $partner->getSlug(), 'slug'   => $compagny->getSlug()]
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
     * @return array[Offre]
     */
    private function getCompagniesFromPartner(Partner $partner)
    {
        return $this->getDoctrineUtil()->getRepository(Compagny::class)->findAllByPartnerWithJoin($partner);
    }
}
