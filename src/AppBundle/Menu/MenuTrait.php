<?php

namespace AppBundle\Menu;

use Knp\Menu\ItemInterface;
use AppBundle\Exception\ClassNotFoundException;
use AppBundle\Exception\UndefinedConstantException;

/**
 * @author Hubsine <contact@hubsine.com>
 */
trait MenuTrait 
{
    protected $paramAvaibles = array('id', 'slug');
    
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
            
            if ( empty( $label ) && $paramName === 'slug' )
            {
                $user = $this->request->attributes->get('user');
                $itemAdded->setLabel($user->getUsername());
            }
            
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
        if( !in_array($paramName, $this->paramAvaibles) )
        {
            throw new \InvalidArgumentException(
                    sprintf('Inavlid argument value "%s" for $paramName. $paramName must be ' . implode(' or ', $this->paramAvaibles), $paramName)
                    );
        }
        
        $paramValue =  $this->request->get($paramName);
        
        return $paramValue;
    }
    
    /**
     * Get class route name 
     * 
     * @param string $className
     * @param type $prefix
     * @return string Constant "ROUTE_PREFIX" value
     * @throws ClassNotFoundException
     * @throws UndefinedConstantException
     */
    public function getCompleteRoute($className, $prefix)
    {
        if( ! class_exists($className) )
        {
            throw new ClassNotFoundException($className);
        }
        
        $constName = $className . '::' . 'ROUTE_PREFIX';
        
        if( ! defined($constName) )
        {
            throw new UndefinedConstantException($constName);
        }
        
        return constant($constName) . '_' . $prefix;
    }
}
