<?php

namespace AppBundle\Menu;

use AppBundle\Menu\AbstractMenuBuilder;
use AppBundle\Entity\User\User;
use AppBundle\Entity\User\Partner\Partner;
use AppBundle\Entity\User\Partner\Compagny;
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
    
    /**
     * Create Partner Menu
     * 
     * @param array $options
     * @return \Knp\Menu\ItemInterface
     */
    public function createPartnerMenu(array $options)
    {
        $partner = $this->request->attributes->get('partner');
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
        # Compagny & Offres
        ###
        $compagny = $menu->addChild('menu.partner.compagny_offres', [
            'route' => $this->routeUtil->getCompleteRoute(Compagny::class, 'index'),
            'routeParameters'   => ['partner' => $partner->getSlug()]
            ])
            ->setExtra('_route', $this->routeUtil->getCompleteRoute(Compagny::class, 'index'))
            ->setAttribute('class', 'nav-item')
            ->setLinkAttribute('class', 'nav-link');
        
        $compagnyNew = $compagny->addChild('compagny', [
            'route' => $this->routeUtil->getCompleteRoute(Compagny::class, 'new'),
            'routeParameters'   => ['partner'   => $partner->getSlug()]
            ])
            ->setDisplay(false);

        if( $compagnyNew->isCurrent() || in_array($_route, [
                $this->routeUtil->getCompleteRoute(Compagny::class, 'show' ),
                $this->routeUtil->getCompleteRoute(Compagny::class, 'new' ),
                $this->routeUtil->getCompleteRoute(Compagny::class, 'update' )
            ])   
        )
        {
            #$compagnyNew->setCurrent(false);
            $compagny->setCurrent(true);
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
}
