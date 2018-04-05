<?php

namespace AppBundle\Menu;

use Symfony\Component\Security\Core\User\UserInterface;
use AppBundle\Menu\AbstractMenuBuilder;
use AppBundle\Entity\User\Partner\Partner;
use AppBundle\Entity\User\Abonne\Abonne;
use AppBundle\Entity\User\Partner\Company;
use AppBundle\Entity\User\Partner\Offre;
use AppBundle\Entity\Admin\Pages\Page;
use AppBundle\Exception\BadInstanceException;

/**
 * Description of FrontMenuBuilder
 *
 * @author Hubsine <contact@hubsine.com>
 */
class FrontMenuBuilder extends AbstractMenuBuilder
{
    /**
     * Create Front Main Menu
     * 
     * @param array $options
     * @return \Knp\Menu\ItemInterface
     */
    public function createMainMenu(array $options)
    {
        $menu = $this->factory->createItem('menu.home', ['route'=>'home'])
               ->setChildrenAttribute('class', 'navbar-nav mr-auto');
        
        ###
        # Login and Register
        ###
        $login      = $menu->addChild('menu.login', ['route'  => 'fos_user_security_login'])
                    ->setDisplay(false);
        
        $register   = $menu->addChild('menu.register', ['route'  => 'fos_user_registration_register'])
                    ->setDisplay(false);
        
        foreach ($menu as $item) 
        {
            $item->setAttribute('class', 'nav-item')
                 ->setLinkAttribute('class', 'nav-link');
            
            $this->addActiveClassOnLink($item, $options);
        }
        
        ###
        # Pages 
        ###
        $pages  = $this->request->attributes->get('pages');
        
        foreach ($pages as $page) 
        {
            $menu
                ->addChild($page->getLabel(), [
                    'route' => $this->routeUtil->getCompleteRoute(Page::class, 'index'),
                    'routeParameters'   => ['slug'  => $page->getSlug()]
                ])
                ->setChildrenAttribute('class', 'nav-item')
                ->setLinkAttribute('class', 'nav-link')
                ;
        }
        
        return $menu;
    }
    
    public function createFooterMenu(array $options)
    {
        $pages  = $this->request->attributes->get('pages');
        
        $menu   = $this->factory->createItem('menu.home', ['route'=>'home'])
                ->setChildrenAttribute('class', 'nav justify-content-center');
        
        foreach ($pages as $page) 
        {
            $menu
                ->addChild($page->getLabel(), [
                    'route' => $this->routeUtil->getCompleteRoute(Page::class, 'index'),
                    'routeParameters'   => ['slug'  => $page->getSlug()]
                ])
                ->setChildrenAttribute('class', 'nav-item')
                ->setLinkAttribute('class', 'nav-link')
                ;
        }
        
        return $menu;
    }

    public function createMainMobileMenu(array $options)
    {
        $user           = $this->tokenStorage->getToken()->getUser();
        $navItemClass   = 'nav-item list-group-item d-flex justify-content-between align-items-center bg-dark p-0';
        $navLinkClass   = 'nav-link w-100 d-flex justify-content-between align-items-center text-white';

        $menu   = $this
            ->factory->createItem('menu.home', [
                'route'     => 'home',
            ])
            ->setChildrenAttribute('class', 'nav flex-column')    
            ;

        if( $user instanceof UserInterface )
        {
            if( $user->isPartner() )
            {
                $menu->addChild('menu.account', [
                    'route'             => $this->routeUtil->getCompleteRoute(Partner::class, 'index'),
                    'routeParameters'   => ['partner'    => $user->getSlug()]
                ])
                    ->setAttribute('class', $navItemClass)
                    ->setLinkAttribute('class', $navLinkClass);
            }

            if( $user->isAbonne() )
            {
                $menu->addChild('menu.account', [
                    'route'             => $this->routeUtil->getCompleteRoute(Abonne::class, 'index'),
                    'routeParameters'   => ['abonne'    => $user->getSlug()]
                ])
                    ->setAttribute('class', $navItemClass)
                    ->setLinkAttribute('class', $navLinkClass);
            }
            
            $menu->addChild('layout.logout', [
                'route'             => 'fos_user_security_logout'
            ])
                ->setAttribute('class', $navItemClass)
                ->setLinkAttribute('class', $navLinkClass);
        }    
        else
        {   
            ###
            # Login 
            ###
            $menu->addChild('menu.login', [
                    'route'  => 'fos_user_security_login',
                    #'routeParameters'   => ['asuser'  => 'abonne'] pas necessaire
                ])
                ->setAttribute('class', $navItemClass)
                ->setLinkAttribute('class', $navLinkClass);

            ###
            # Register
            ###
            $menu->addChild('menu.register', [
                    'route'  => 'fos_user_registration_register',
                    'routeParameters'   => ['asuser'  => 'abonne']
                ])
                ->setAttribute('class', $navItemClass)
                ->setLinkAttribute('class', $navLinkClass);
            }
            
        return $menu;
    }
    
    /**
     * Créer le menu qui est affiché lorsque l'utilisateur n'est pas connecté 
     * 
     * @param array $options
     * @return \Knp\Menu\ItemInterface
     */
    public function createLogoutMenu(array $options)
    {
        $menu = $this->factory->createItem('menu.home', ['route'=>'home'])
               ->setChildrenAttribute('class', 'nav position-absolute right-0 mr-3');
        
        ###
        # Login 
        ###
        $login  = $menu->addChild('menu.login', [
                'route'  => 'fos_user_security_login',
                #'routeParameters'   => ['asuser'  => 'abonne'] pas necessaire
            ])
            ->setAttribute('class', 'mr-2 nav-item')
            ->setLinkAttribute('class', 'nav-link border border-success');
        
        ###
        # Register
        ###
        $register   = $menu->addChild('menu.register', [
                'route'  => 'fos_user_registration_register',
                'routeParameters'   => ['asuser'  => 'abonne']
            ])
            ->setAttribute('class', 'nav-item')
            ->setLinkAttribute('class', 'nav-link border border-secondary');
        
        return $menu;
    }
    
    public function createUserAccountMenu(array $options)
    {
        $partner    = $this->request->attributes->get('partner');
        $abonne     = $this->request->attributes->get('abonne');
        
        if( ! $partner instanceof Partner && ! $abonne instanceof Abonne)
        {
            throw new BadInstanceException($partner, Partner::class);
        }
        
        return $menu = $partner instanceof Partner ? $this->createPartnerMenu($options, $partner) : $this->createAbonneMenu($options, $abonne);
    }
    
    /**
     * Create Partner Menu
     * 
     * @param array $options
     * @return \Knp\Menu\ItemInterface
     */
    private function createPartnerMenu(array $options, $partner)
    {
        $_route     = $this->request->attributes->get('_route');
        
        if ( ! $partner instanceof Partner )
        {
            throw new BadInstanceException($partner, Partner::class);
        }
        
        $menu = $this->factory->createItem('menu.partner.partner', [
                'route' => 'home'
            ])
            ->setChildrenAttribute('class', 'nav');

        ###
        # Partner
        ###
        $partnerItem = $menu->addChild('Partner', [
            'route' => $this->routeUtil->getCompleteRoute(Partner::class, 'index'),
            'routeParameters'   => ['partner' => $partner->getSlug()]
        ])
            ->setExtra('_route', $this->routeUtil->getCompleteRoute(Partner::class, 'index'))
            ->setAttribute('class', 'nav-item')
            ->setLinkAttribute('class', 'nav-link');
        
        $partnerItem->addChild('partner', [
            'route' => $this->routeUtil->getCompleteRoute(Partner::class, 'update'),
            'routeParameters'   => ['partner' => $partner->getSlug()]
        ])
            ->setDisplay(false);
        
        if(in_array($_route, [$this->routeUtil->getCompleteRoute(Partner::class, 'update')]))
        {
            $partnerItem->setCurrent(true);
        }
        
        ###
        # Company & Offres
        ###
        $company = $menu->addChild('menu.partner.company_offres', [
            'route' => $this->routeUtil->getCompleteRoute(Company::class, 'index'),
            'routeParameters'   => ['partner' => $partner->getSlug()]
            ])
            ->setExtra('_route', $this->routeUtil->getCompleteRoute(Company::class, 'index'))
            ->setAttribute('class', 'nav-item')
            ->setLinkAttribute('class', 'nav-link');
        
//        $companyNew = $company->addChild('company', [
//            'route' => $this->routeUtil->getCompleteRoute(Company::class, 'new'),
//            'routeParameters'   => ['partner'   => $partner->getSlug()]
//            ])
//            ->setDisplay(false);

        if( in_array($_route, [
                $this->routeUtil->getCompleteRoute(Company::class, 'show' ),
                $this->routeUtil->getCompleteRoute(Company::class, 'new' ),
                $this->routeUtil->getCompleteRoute(Company::class, 'update' ),
                $this->routeUtil->getCompleteRoute(Offre::class, 'new' ),
                $this->routeUtil->getCompleteRoute(Offre::class, 'update' )
            ])   
        )
        {
            #$companyNew->setCurrent(false);
            $company->setCurrent(true);
        }
                
        ###
        # Parameters 
        ###
        $menu->addChild('menu.partner.parameters', [
            'route' => $this->routeUtil->getCompleteRoute(Partner::class, 'edit_parameters'),
            'routeParameters'   => ['partner'  => $partner->getSlug()]
        ])
            ->setExtra('_route', $this->routeUtil->getCompleteRoute(Partner::class, 'edit_parameters'))
            ->setAttribute('class', 'nav-item')
            ->setLinkAttribute('class', 'nav-link');
        
            
        #$this->addActiveClassOnLink($item, $options, ['bg-white']);
        
        return $menu;
    }
    
    /**
     * Create Partner Menu
     * 
     * @param array $options
     * @return \Knp\Menu\ItemInterface
     */
    private function createAbonneMenu(array $options, $abonne)
    {
        $_route     = $this->request->attributes->get('_route');
        
        if ( ! $abonne instanceof Abonne )
        {
            throw new BadInstanceException($abonne, Abonne::class);
        }
        
        $menu = $this->factory->createItem('menu.abonne.abonne', [
                'route' => 'home'
            ])
            ->setChildrenAttribute('class', 'nav');

        ###
        # Abonne
        ###
        $abonneItem = $menu->addChild('Abonne', [
            'route' => $this->routeUtil->getCompleteRoute(Abonne::class, 'index'),
            'routeParameters'   => ['abonne' => $abonne->getSlug()]
        ])
            ->setExtra('_route', $this->routeUtil->getCompleteRoute(Abonne::class, 'index'))
            ->setAttribute('class', 'nav-item')
            ->setLinkAttribute('class', 'nav-link');
        
        $abonneItem->addChild('abonne', [
            'route' => $this->routeUtil->getCompleteRoute(Abonne::class, 'update'),
            'routeParameters'   => ['abonne' => $abonne->getSlug()]
        ])
            ->setDisplay(false);
        
        if(in_array($_route, [$this->routeUtil->getCompleteRoute(Abonne::class, 'update')]))
        {
            $abonneItem->setCurrent(true);
        }
        
        ###
        # Parameters 
        ###
        $menu->addChild('menu.abonne.parameters', [
            'route' => $this->routeUtil->getCompleteRoute(Abonne::class, 'edit_parameters'),
            'routeParameters'   => ['abonne'  => $abonne->getSlug()]
        ])
            ->setExtra('_route', $this->routeUtil->getCompleteRoute(Abonne::class, 'edit_parameters'))
            ->setAttribute('class', 'nav-item')
            ->setLinkAttribute('class', 'nav-link');
        
        return $menu;
    }
    
    public function createSidebarMenu(array $options)
    {
        $_route         = $this->getRouteName();
        $allCount       = 0;
        $is             = isset( $options['is'] ) ? $options['is'] : 'header';
        
        $extraLabelHtml = '<span class="badge badge-primary badge-pill ml-3">%s</span>';
        $navItemClass   = 'nav-item list-group-item d-flex justify-content-between align-items-center';
        $navItemClass  .= $is === 'footer' ? ' bg-dark p-0' : '';
        $navLinkClass   = 'nav-link w-100 d-flex justify-content-between align-items-center';
        $navLinkClass   .= $is === 'footer' ? ' text-white' : '';
        
        $categories     = $options['categories'];
        $offre          = $options['offre'];
        
        $menu   = $this->factory->createItem('menu.sidebar.all', [
                'route' => 'home'
            ])
            ->setChildrenAttribute('class', 'nav flex-column');
        
        $allItem = $menu
                ->addChild('menu.sidebar.all', [
                    'route' => 'home'
                ])
                ->setAttribute('class', $navItemClass)
                ->setLinkAttribute('class', $navLinkClass)
            ;
        
        foreach ($categories as $category) 
        {
            $countOffre = $category->getOffres()->count();
            
            $menuItem = $menu->addChild($category->getName(), [
                'route' => $this->routeUtil->getCompleteRoute(Offre::class, 'category'),
                'routeParameters'   => ['slug'  => $category->getSlug()]
            ])
            ->setAttribute('class', $navItemClass)
            ->setLinkAttribute('class', $navLinkClass)
            ->setLabel($category->getName() . sprintf($extraLabelHtml, $countOffre))
            ->setExtra('safe_label', true)        
            ;
            
            if( $_route === $this->routeUtil->getCompleteRoute(Offre::class, 'single') && $offre instanceof Offre && $category->getOffres()->contains($offre) )
            {
                $menuItem
                    ->addChild($offre->getName(), [
                        'route' => $this->routeUtil->getCompleteRoute(Offre::class, 'single'),
                        'routeParameters'   => [ 'slug'  => $offre->getSlug() ]
                    ])
                    ->setDisplay(false)
                    ;
                
                $menuItem->setAttribute('class', $navItemClass . ' ' . 'active bg-light' );
            }
        
            $allCount += $countOffre;
        }
        
        $allItem
            ->setLabel( $this->translator->trans('menu.sidebar.all') . sprintf($extraLabelHtml, $allCount))
            ->setExtra('safe_label', true)   
        ;
        
        return $menu;
    }
}
