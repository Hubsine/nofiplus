<?php

namespace AppBundle\Menu;

use Doctrine\Common\Collections\Collection;
use AppBundle\Menu\AbstractMenuBuilder;
use AppBundle\Entity\User\Partner\Partner;
use AppBundle\Entity\User\Abonne\Abonne;
use AppBundle\Entity\User\Partner\Company;
use AppBundle\Entity\User\Partner\Offre;
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
               ->setChildrenAttribute('class', 'nav');
        
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
        $allCount       = 0;
        
        $extraLabelHtml = '<span class="badge badge-primary badge-pill">%s</span>';
        $navItemClass   = 'nav-item list-group-item d-flex justify-content-between align-items-center';
        $navLinkClass   = 'nav-link w-100 d-flex justify-content-between align-items-center';
        
        $categories     = $options['categories'];
        
        $menu   = $this->factory->createItem('menu.sidebar', [
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
            
            $menu->addChild($category->getName(), [
                'route' => 'home_compagny_category',
                'routeParameters'   => ['slug'  => $category->getSlug()]
            ])
            ->setAttribute('class', $navItemClass)
            ->setLinkAttribute('class', $navLinkClass)
            ->setLabel($category->getName() . sprintf($extraLabelHtml, $countOffre))
            ->setExtra('safe_label', true)        
            ;
            
            $allCount += $countOffre;
        }
        
        $allItem
            ->setLabel('menu.sidebar.all')
            ->setExtra('safe_label', true)   
        ;
        
        return $menu;
    }
    
}
