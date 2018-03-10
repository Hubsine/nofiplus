<?php

namespace AppBundle\Menu;

use Knp\Menu\ItemInterface;

/**
 * @author Hubsine <contact@hubsine.com>
 */
trait MenuTrait 
{
    /**
     * Add "active" class on a link element if route name match
     * 
     * @param ItemInterface $item
     * @param array $options
     * @return ItemInterface
     */
    public function addActiveClassOnLink(ItemInterface $item, array $options, array $extrasClass = array())
    {
        if( isset($options['_route']) && $options['_route'] === $item->getExtra('_route') )
        {
            return $item->setLinkAttribute('class', 'nav-link active ' . implode(' ', $extrasClass));
        }
            
        return $item;
    }
    
    /**
     * Add child Menu ItemInterface with route paramater from request attributes
     * 
     * @param ItemInterface $item
     * @param string $routeName
     * @param string $paramName
     * @param string $label
     * @return ItemInterface
     */
    public function addChildByParam(ItemInterface $item, $routeName, $paramName, $label = '')
    {
        $_route     = $this->request->attributes->get('_route');
        $paramValue = $this->getParamValue($paramName);
        
        if( $_route === $routeName || !empty($paramValue) )
        {
            $itemAdded = $item->addChild($label, array(
                'route'  => $routeName,
                'routeParameters'  => array($paramName=> $paramValue)
            ));
            
            return $itemAdded;
        }
        
        return $item;
    }
    
    /**
     * Get value of paramName from request attributes
     * 
     * @param string $paramName
     * @return string
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     */
    protected function getParamValue($paramName)
    {
        $paramValue =  $this->request->get($paramName);
        
        return $paramValue;
    }
}
