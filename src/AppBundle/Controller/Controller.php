<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;
use FOS\UserBundle\Model\User;
use Symfony\Component\Security\Csrf\CsrfToken;

/**
 * Description of Controller
 *
 * @author Hubsine <contact@hubsine.com>
 */
abstract class Controller extends BaseController
{
    /**
     * Get AclSecurityManager 
     * 
     * @return \AppBundle\Security\AclSecurityManager
     */
    protected function getAclManager()
    {
        return $this->get('app.security.acl_manager');
    }
    
    /**
     * Checks if the attributes are granted against the current authentication token and optionally supplied subject.
     * If is false, a denyAccessUnlessGranted is throw. For user with ROLE_SUPER_ADMIN access is always granted.
     * 
     * @param mixed $attributes
     * @param mixed $subject
     * @param string $message
     * @return bolean
     */
    protected function isGrantedWithDeny($attributes, $subject = null, $message = 'Access Denied.') {
        
        $isGranted = $this->isGranted($attributes, $subject);
       
        if( $isGranted === false && ! $this->getUser()->hasRole(User::ROLE_SUPER_ADMIN) )
        {
            $this->denyAccessUnlessGranted($isGranted, $subject, $message);
        }
        
        return $isGranted;
    }


    /**
     * Gets the ObjectRepository for an persistent object.
     *
     * @param string $persistentObject      The name of the persistent object.
     * @param string $persistentManagerName The object manager name (null for the default one).
     *
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    protected function getRepository($persistentObject, $persistentManagerName = null)
    {
        return $this->getDoctrine()->getRepository($persistentObject, $persistentManagerName = null);
    }
    
    /**
     * Get Doctrine Util 
     * 
     * @return \AppBundle\Doctrine\DoctrineUtil
     */
    protected function getDoctrineUtil()
    {
        return $this->get('app.doctrine.util');
    }
    
    /**
     * Get Event Dispatcher 
     * 
     * @return \Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    protected function getEventDispatcher()
    {
        return $dispatcher = $this->get('event_dispatcher');
    }
    
    /**
     * Get Route Util
     * 
     * @return AppBundle\Util\RouteUtil
     */
    protected function getRouteUtil()
    {
        return $this->get('app.util.route');
    }
    
    /**
     * Get complete route 
     * 
     * @uses AppBundle\Util\RouteUtil::getCompleteRoute
     * 
     * @param string $className
     * @param string $prefix
     * @return string 
     */
    protected function getCompleteRoute($className, $prefix)
    {
        return $this->getRouteUtil()->getCompleteRoute($className, $prefix);
    }

    /**
     * Check if token provided in url for delete an entity is valid
     * 
     * @param string $tokenName
     * @throws TokenNotFoundException
     */
    protected function checkDeleteToken($tokenName = 'token')
    {
        $submittedToken = $this->get('request_stack')->getCurrentRequest()->query->get($tokenName);
        
        if( ! $this->isCsrfTokenValid( 'delete-entity', $submittedToken) )
        {
            throw new TokenNotFoundException('Token not found');
        }
    }
}
