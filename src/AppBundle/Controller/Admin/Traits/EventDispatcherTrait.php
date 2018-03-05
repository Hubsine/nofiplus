<?php

namespace AppBundle\Controller\Admin\Traits;

use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Form\FormInterface;
use AppBundle\Event\Admin\AdminCrudEvent;
use AppBundle\Event\Admin\AdminCrudFormEvent;
use AppBundle\Event\Admin\AdminCrudFilterUserResponseEvent;

/**
 * Event Dispatcher Trait 
 * 
 * @author Hubsine <contact@hubsine.com>
 */
trait EventDispatcherTrait 
{
    /**
     * Dispatch AdminCrudEvent
     * 
     * @param UserInterface $user
     * @param string $eventName
     * @param Request $request
     * 
     * @return AdminCrudEvent
     */
    protected function dispatchAdminCrudEvent(UserInterface $user, $eventName, Request $request = null)
    {
        $event = new AdminCrudEvent($user, $request);
        
        $this->getEventDispatcher()->dispatch($eventName, $event);
        
        return $event;
    }
    
    /**
     * Dispatch AdminCrudFormEvent 
     * 
     * @param FormInterface $form
     * @param Request $request
     * @param string $eventName
     * 
     * @return AdminCrudFormEvent
     */
    protected function dispatchAdminCrudFormEvent(FormInterface $form, Request $request, $eventName)
    {
        $event = new AdminCrudFormEvent($form, $request);
        
        $this->getEventDispatcher()->dispatch($eventName, $event);
        
        return $event;
    }
    
    /**
     * Dispatch AdminCrudFilterUserResponse 
     * 
     * @param UserInterface $user
     * @param Request $request
     * @param string $response
     * 
     * @return AdminCrudFilterUserResponseEvent
     */
    protected function dispatchAdminCrudFilterUserResponseEvent(UserInterface $user, Request $request, $response, $eventName)
    {
        $event = new AdminCrudFilterUserResponseEvent($user, $request, $response);
        
        $this->getEventDispatcher()->dispatch($eventName, $event);
        
        return $event;
    }
    
}
