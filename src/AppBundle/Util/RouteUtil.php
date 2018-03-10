<?php

namespace AppBundle\Util;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use AppBundle\Exception\ClassNotFoundException;
use AppBundle\Exception\UndefinedConstantException;

/**
 * Description of RouteUtil
 *
 * @author Hubsine <contact@hubsine.com>
 */
class RouteUtil 
{
    /**
     * @var Router
     */
    private $router;
    
    /**
     * @var RequestStack
     */
    private $requestStack;
    
    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    private $request;


    public function __construct(Router $router, RequestStack $requestStack) 
    {
        $this->router   = $router;
        $this->requestStack = $requestStack;
        $this->request      = $requestStack->getCurrentRequest();
    }

    /**
     * Get class route name from entity route prefix
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
    
    /**
     * Get current route name
     * 
     * @return string
     */
    public function getCurrentRouteName()
    {
        return $this->request->attributes->get('_route');
    }
}
