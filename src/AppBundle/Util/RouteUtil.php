<?php

namespace AppBundle\Util;

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
}
