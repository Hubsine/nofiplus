<?php

namespace AppBundle\Menu;

use AppBundle\Menu\AbstractMenuBuilder;
use AppBundle\Entity\User\User;
use AppBundle\Entity\User\Partner\Partner;

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
        $menu = $this->factory->createItem('menu.partner.partner', [
                'route' => 'home'
            ])
            ->setChildrenAttribute('class', 'nav');

        ###
        # Partner
        ###
        $partner = $this->addChildByParam($menu, $this->routeUtil->getCompleteRoute(Partner::class, 'index'), 'slug', 'Partner')
             ->setExtra('_route', $this->routeUtil->getCompleteRoute(Partner::class, 'index'));
        
        $this->addChildByParam($partner, $this->routeUtil->getCompleteRoute(Partner::class, 'edit'), 'slug', 'Partner')
             ->setExtra('_route', $this->routeUtil->getCompleteRoute(Partner::class, 'edit'))
            ->setDisplay(false);
        
        ###
        # Compagny @ Offres
        ###
//        $this->addChildByParam($menu, $this->routeUtil->getCompleteRoute(Partner::class, 'index'), 'slug', 'menu.partner.compagny_offres')
//            ->setExtra('_route', $this->routeUtil->getCompleteRoute(Partner::class, 'edit'));
        
        ###
        # Parameters 
        ###
//        $this->addChildByParam($menu, $this->routeUtil->getCompleteRoute(Partner::class, 'edit_parameters'), 'slug', 'menu.partner.parameters')
//            ->setExtra('_route', $this->routeUtil->getCompleteRoute(Partner::class, 'edit_parameters'));
        
        foreach ($menu as $item) 
        {
            $item->setAttribute('class', 'nav-item')
                 ->setLinkAttribute('class', 'nav-link');
            
            $this->addActiveClassOnLink($item, $options, ['bg-white']);
        }
        
        return $menu;
    }
}
