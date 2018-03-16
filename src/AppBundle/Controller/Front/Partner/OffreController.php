<?php

namespace AppBundle\Controller\Front\Partner;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use AppBundle\Exception\UnexpectedValueException;
use AppBundle\Controller\Controller;
use AppBundle\Entity\User\Partner\Partner;
use AppBundle\Entity\User\Partner\Compagny;
use AppBundle\Entity\User\Partner\Offre;
use AppBundle\Form\Type\User\Partner\OffreType;
use AppBundle\Controller\Front\Partner\CompagnyController;

class OffreController extends Controller
{
    /**
     * @ParamConverter("partner", class="AppBundle:User\Partner\Partner", options={"repository_method" = "findOneForIndex"})
     * 
     * @param Request $request
     * @param string $compagny is slug, not Compagny object
     * @return Response
     */
    public function newAction(Request $request, Partner $partner, $compagny)
    {
        $compagnies = $this->getDoctrineUtil()->getRepository(Compagny::class)->findAllByForIndex($partner);
        $compagny   = CompagnyController::getFilterCompagny($compagnies, $compagny);
        $request->attributes->set('compagny', $compagny);
        
        $form       = $this->createForm( OffreType::class, $offre = new Offre() );
        
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
            #'currentOffre'   => $offre,
            'currentCompagny'   => $compagny,
            'compagnies'    => $compagnies
        ]);
    }
    
    /**
     * @ParamConverter("partner", class="AppBundle:User\Partner\Partner", options={"repository_method" = "findOneForIndex"})
     * 
     * @param Request $request
     * @param string $compagny slug
     * @param strig $slug slug of Offre
     * @return Response
     * @throws AccessDeniedException
     */
    public function updateAction(Request $request, Partner $partner, $compagny, $slug)
    {
        $compagnies = $this->getDoctrineUtil()->getRepository(Compagny::class)->findAllByForShow($partner);
        $compagny   = CompagnyController::getFilterCompagny($compagnies, $compagny);
        
        $request->attributes->set('compagny', $compagny);
        
        $offre      = self::getFilterOffres($compagny->getOffres()->getValues(), $slug);
        
        $request->attributes->set('compagny', $compagny);
        $request->attributes->set('slug', $offre);
        
        $this->isGrantedWithDeny('EDIT', $offre);
        
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
            #'currentOffre'   => $offre,
            'currentCompagny'   => $compagny,
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
     * Get Offre from array collection of Offre
     * 
     * @param array $offres
     * @param string $offreSlug
     * @return array
     * @throws UnexpectedValueException
     */
    public static function getFilterOffres(array $offres, $offreSlug)
    {
        for($i = 0; $i < count($offres); $i++)
        {
            if( $offreSlug === $offres[$i]->getSlug() )
            {
                return $offres[$i];
            }
        }
        
        throw new UnexpectedValueException(null, Offre::class);
    }
}
