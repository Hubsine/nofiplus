<?php

namespace AppBundle\Menu;

use AppBundle\Menu\AbstractMenuBuilder;
use AppBundle\Entity\Admin\Category\Carte;
use AppBundle\Entity\Admin\Category\Offre;
use AppBundle\Entity\Admin\Category\Company;

/**
 * Description of AdminMenuBuilder
 *
 * @author Hubsine <contact@hubsine.com>
 */
class AdminMenuBuilder extends AbstractMenuBuilder
{
    /**
     * Create Main Menu
     * 
     * @param array $options
     * @return \Knp\Menu\ItemInterface
     */
    public function createMainMenu(array $options)
    {
        $menu = $this->factory->createItem('root')
                ->setChildrenAttribute('class', 'navbar-nav px-3')
                ;

        $menu->addChild( 'Logout', array('route' => 'fos_user_security_logout') )
                ->setAttribute('class', 'nav-item text-nowrap')
                ->setLinkAttribute('class', 'nav-link');
        
        return $menu;
    }
    
    /**
     * Create Sidebar Menu
     * 
     * @param array $options
     * @return \Knp\Menu\ItemInterface
     */
    public function createSidebarMenu(array $options)
    {
        $menu = $this->factory->createItem('Admin', array('route'=>'admin_home'))
               ->setChildrenAttribute('class', 'nav flex-column');
        
        ###
        # Category
        ###
        $category   = $menu->addChild('Category', array());
        $category->setLinkAttribute('class', 'disabled')
                ->setUri("#");
        
        ###
        # Carte
        ###
        $carte = $category->addChild('Carte', array('route' => Carte::ROUTE_PREFIX . '_index'))
                ->setExtra('_route', Carte::ROUTE_PREFIX . '_index')
                ->setDisplayChildren(false);
        
        $carte->addChild('New', array('route'  => Carte::ROUTE_PREFIX . '_new'));
        $this->addChildByParam($carte, Carte::ROUTE_PREFIX . '_update', 'id', 'Update');
        
        ###
        # Company
        ###
        $company = $category->addChild('Company', array('route' => Company::ROUTE_PREFIX . '_index'))
                ->setExtra('_route', Company::ROUTE_PREFIX . '_index')
                ->setDisplayChildren(false);
        
        $company->addChild('New', array('route'  => Company::ROUTE_PREFIX . '_new'));
        $this->addChildByParam($carte, Company::ROUTE_PREFIX . '_update', 'id', 'Update');
        
        ###
        # Offre
        ###
        $offre = $category->addChild('Offre', array('route' => Offre::ROUTE_PREFIX . '_index'))
                ->setExtra('_route', Offre::ROUTE_PREFIX . '_index')
                ->setDisplayChildren(false);
        
        $offre->addChild('New', array('route'  => Offre::ROUTE_PREFIX . '_new'));
        $this->addChildByParam($carte, Offre::ROUTE_PREFIX . '_update', 'id', 'Update');
        
        foreach ($menu as $item) 
        {
            $item->setAttribute('class', 'nav-item')
                 ->setLinkAttribute('class', 'nav-link');
            
            $this->addActiveClassOnLink($item, $options);
        }
        
        return $menu;
    }
}
