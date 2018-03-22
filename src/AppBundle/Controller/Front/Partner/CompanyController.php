<?php

namespace AppBundle\Controller\Front\Partner;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use AppBundle\Exception\UnexpectedValueException;
use AppBundle\Controller\Controller;
use AppBundle\Entity\User\Partner\Partner;
use AppBundle\Entity\User\Partner\Company;
use AppBundle\Form\Type\User\Partner\CompanyType;

class CompanyController extends Controller
{
    /**
     * @ParamConverter("partner", class="AppBundle:User\Partner\Partner", options={"repository_method" = "findOneForIndex"})
     * 
     * @param Request $request
     * @param Partner $partner
     * @return type
     */
    public function indexAction(Partner $partner)
    {
        $this->isGrantedWithDeny('VIEW', $partner);
        
        // replace this example code with whatever you need
        return $this->render('@Front/User/Profile/Partner/Company/index.html.twig', [
            'partner'       => $partner,
            'compagnies'    => $partner->getCompagnies()
        ]);
    }
    
    /**
     * @ParamConverter("partner", class="AppBundle:User\Partner\Partner", options={"repository_method" = "findOneForIndex"})
     * 
     * @param string $slug
     * @return Response
     */
    public function showAction(Request $request, Partner $partner, $slug)
    {
        $compagnies = $this->getDoctrineUtil()->getRepository(Company::class)->findAllByForShow($partner);
        $company   = self::getFilterCompany($compagnies, $slug);
        
        $request->attributes->set('slug', $company);
        
        $this->isGrantedWithDeny('VIEW', $company);
        
        // replace this example code with whatever you need
        return $this->render('@Front/User/Profile/Partner/Company/show.html.twig', [
            'partner'  => $partner, 
            'currentCompany'  => $company,
            'compagnies' => $compagnies
        ]);
    }
    
    /**
     * @ParamConverter("partner", class="AppBundle:User\Partner\Partner", options={"repository_method" = "findOneForIndex"})
     * 
     * @param Request $request
     * @return Response
     */
    public function newAction(Request $request, Partner $partner)
    {
        $compagnies = $this->getDoctrineUtil()->getRepository(Company::class)->findAllByForIndex($partner);
        
        $form   = $this->createForm( CompanyType::class, $company = new Company() );
        
        $company->setPartner($partner);

        $form->handleRequest($request);
        
        if( $form->isSubmitted() && $form->isValid() )
        {
            $this->getDoctrineUtil()->persist($company);
            
            $maskBuilder    = $this->getAclManager()->getMaskBuilder(MaskBuilder::MASK_OPERATOR);
            
            $this->getAclManager()->insertObjectAce($company, $maskBuilder, $partner);
            $this->getAclManager()->insertObjectAce($company->getAddress(), $maskBuilder, $partner);
            $this->getAclManager()->insertObjectAce($company->getLogo(), $maskBuilder, $partner);
            
            $this->addFlash('success', 'flash.add_success');
            
            return $this->redirectToRoute(
                    $this->getRouteUtil()->getCompleteRoute(Company::class, 'index'),
                    ['partner' => $partner->getSlug()]
                );
        }
        
        // replace this example code with whatever you need
        return $this->render('@Front/User/Profile/Partner/Company/new.html.twig', [
            'partner'  => $partner, 
            'form'  => $form->createView(),
            'compagnies'    => $compagnies
        ]);
    }
    
    /**
     * @ParamConverter("partner", class="AppBundle:User\Partner\Partner", options={"repository_method" = "findOneForUpdateCompany"})
     * 
     * @param Request $request
     * @return Response
     * @throws AccessDeniedException
     */
    public function updateAction(Request $request, Partner $partner, $slug)
    {
        $compagnies = $partner->getCompagnies();
        $company   = self::getFilterCompany($compagnies->getValues(), $slug);
        
        $request->attributes->set('company', $company);
        
        $this->isGrantedWithDeny('EDIT', $company);
        
        $form   = $this->createForm( CompanyType::class, $company, ['validation_groups'=> ['Default'], 'action'   => 'update'] );
        
        $form->handleRequest($request);
        
        if( $form->isSubmitted() && $form->isValid() )
        {
            $this->getDoctrineUtil()->merge($company);
            
            $this->addFlash('success', 'flash.update_success');
            
            return $this->redirectToRoute(
                $this->getRouteUtil()->getCompleteRoute(Company::class, 'show'),
                ['partner' => $partner->getSlug(), 'slug'   => $company->getSlug()]
            );
        }
        
        // replace this example code with whatever you need
        return $this->render('@Front/User/Profile/Partner/Company/update.html.twig', [
            'partner'  => $partner, 
            'form'  => $form->createView(),
            'currentCompany'   => $company,
            'compagnies'    => $compagnies
        ]);
    }
    
    /**
     * @ParamConverter("partner", options={"mapping": {"partner": "slug"}})
     * 
     * @param Request $request
     * @param Partner $partner
     * @param Company $company
     * @return Response
     */
    public function deleteAction(Request $request, Partner $partner, Company $company)
    {
        $this->isGrantedWithDeny('DELETE', $company);
        $this->checkDeleteToken();
        
        $this->getDoctrineUtil()->remove($company);
            
        $this->addFlash('success', 'flash.delete_success');
            
        return $this->redirectToRoute(
            $this->getRouteUtil()->getCompleteRoute(Company::class, 'index'),
            ['partner' => $partner->getSlug()]
        );
    }
    
    /**
     * Get a Company from array of Company
     * @param array $compagnies
     * @param string $companySlug
     * @return array
     * @throws UnexpectedValueException
     */
    public static function getFilterCompany(array $compagnies, $companySlug)
    {
        for($i = 0; $i < count($compagnies); $i++)
        {
            if( $compagnies[$i]->getSlug() === $companySlug )
            {
                return $compagnies[$i];
            }
        }
        
        throw new UnexpectedValueException(null, Company::class);
    }
}
