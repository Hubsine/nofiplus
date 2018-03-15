<?php

namespace AppBundle\Controller\Front\Partner;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use AppBundle\Exception\UnexpectedValueException;
use AppBundle\Controller\Controller;
use AppBundle\Entity\User\Partner\Partner;
use AppBundle\Entity\User\Partner\Compagny;
use AppBundle\Form\Type\User\Partner\CompagnyType;

class CompagnyController extends Controller
{
    /**
     * 
     * @param Request $request
     * @param Partner $partner
     * @return type
     */
    public function indexAction()
    {
        $partner = $this->getUser();
        $this->isGrantedWithDeny('VIEW', $partner);
        
        // replace this example code with whatever you need
        return $this->render('@Front/User/Profile/Partner/Compagny/index.html.twig', [
            'partner'   => $partner,
            'compagnies' => $this->getDoctrineUtil()->getRepository(Compagny::class)->findAllByForIndex($partner)
        ]);
    }
    
    /**
     * 
     * @param string $slug
     * @return Response
     */
    public function showAction($slug)
    {
        $partner    = $this->getUser();
        $compagnies = $this->getDoctrineUtil()->getRepository(Compagny::class)->findAllByForShow($partner);
        $compagny   = self::getFilterCompagny($compagnies, $slug);
        
        $this->isGrantedWithDeny('VIEW', $compagny);
        
        // replace this example code with whatever you need
        return $this->render('@Front/User/Profile/Partner/Compagny/show.html.twig', [
            'partner'  => $partner, 
            'currentCompagny'  => $compagny,
            'compagnies' => $compagnies
        ]);
    }
    
    /**
     * 
     * @param Request $request
     * @return Response
     */
    public function newAction(Request $request)
    {
        $partner    = $this->getUser();
        $compagnies = $this->getDoctrineUtil()->getRepository(Compagny::class)->findAllByForIndex($partner);
        
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
            'compagnies'    => $compagnies
        ]);
    }
    
    /**
     * @param Request $request
     * @return Response
     * @throws AccessDeniedException
     */
    public function updateAction(Request $request, $slug)
    {
        $partner    = $this->getUser();
        $compagnies = $this->getDoctrineUtil()->getRepository(Compagny::class)->findAllByForIndex($partner);
        $compagny   = self::getFilterCompagny($compagnies, $slug);
        
        $this->isGrantedWithDeny('EDIT', $compagny);
        
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
    
    public static function getFilterCompagny(array $compagnies, $compagnySlug)
    {
        for($i = 0; $i <= count($compagnies); $i++)
        {
            if( $compagnies[$i]->getSlug() === $compagnySlug )
            {
                return $compagnies[$i];
            }
        }
        
        throw new UnexpectedValueException(null, Compagny::class);
    }
}
