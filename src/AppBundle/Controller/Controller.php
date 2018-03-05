<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;
Use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\Entity\EntityInterface;

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
     * If is false, a denyAccessUnlessGranted is throw
     * 
     * @param mixed $attributes
     * @param mixed $subject
     * @param string $message
     * @return bolean
     */
    protected function isGrantedWithDeny($attributes, $subject = null, $message = 'Access Denied.') {
        
        $isGranted = $this->isGranted($attributes, $subject);
        
        if( $isGranted === false )
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
}
