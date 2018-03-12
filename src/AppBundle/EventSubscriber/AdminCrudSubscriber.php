<?php

namespace AppBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\Exception\TokenNotFoundException;
use AppBundle\AppBundleAdminEvents;
use AppBundle\Event\Admin\AdminCrudEvent;

/**
 * Description of AdminCrudSubscriber
 *
 * @deprecated since version 1.0 To remove
 * 
 * @author Hubsine <contact@hubsine.com>
 */
class AdminCrudSubscriber implements EventSubscriberInterface
{
    /**
     * @var string[]
     */
    private static $flashMessages = array(
        AppBundleAdminEvents::ADMIN_ENTITY_NEW_COMPLETED        => array('type' => 'success',   'message' => 'flash.add_success'),
        AppBundleAdminEvents::ADMIN_ENTITY_UPDATE_COMPLETED     => array('type' => 'success',   'message' => 'flash.update_success'),
        AppBundleAdminEvents::ADMIN_ENTITY_DELETE_COMPLETED     => array('type' => 'success',   'message' => 'flash.delete_success'),
        AppBundleAdminEvents::ADMIN_ENTITY_DELETE_FAILURE       => array('type' => 'danger',    'message' => 'flash.delete_failure')
    );

    /**
     * @var \Symfony\Component\HttpFoundation\Session\Session
     */
    private $session;
    
    /**
     * @var \Symfony\Component\Security\Csrf\CsrfTokenManagerInterface
     */
    private $tokenManager;
    
    /**
     * Constructor 
     * 
     * @param Session $session
     */
    public function __construct(SessionInterface $session, CsrfTokenManagerInterface $tokenManager) 
    {
        $this->session      = $session;
        $this->tokenManager = $tokenManager;
    }
    
    /**
     * {@inheritdoc}
     * 
     * @return array
     */
    static public function getSubscribedEvents()
    {
        return array(
            ###
            # INITIALIZE
            ####
            AppBundleAdminEvents::ADMIN_ENTITY_DELETE_INITIALIZE    => 'checkDeleteToken',
            
            ###
            # COMPLETED
            ###
            AppBundleAdminEvents::ADMIN_ENTITY_NEW_COMPLETED        => 'addFlash',
            AppBundleAdminEvents::ADMIN_ENTITY_UPDATE_COMPLETED     => 'addFlash',
            AppBundleAdminEvents::ADMIN_ENTITY_DELETE_COMPLETED     => 'addFlash',
            AppBundleAdminEvents::ADMIN_ENTITY_DELETE_FAILURE       => 'addFlash'
        );
    }
  
    /**
     * Add flash message in session after form process is okey
     * 
     * @param Event $event
     * @param type $eventName
     * @throws \InvalidArgumentException
     */
    public function addFlash(Event $event, $eventName)
    {
        if (!isset(self::$flashMessages[$eventName])) {
            throw new \InvalidArgumentException('This event does not correspond to a known flash message');
        }
        
        $flashType          = self::$flashMessages[$eventName]['type'];
        $flashMessage       = self::$flashMessages[$eventName]['message'];
        
        $this->session->getFlashBag()->add($flashType, $flashMessage);
    }
    
    /**
     * Add flash message in session after form process is okey
     * 
     * @param Event $event
     * @param type $eventName
     * @throws \InvalidArgumentException
     */
    public function addFlashFailure(Event $event, $eventName)
    {
        if (!isset(self::$flashMessages[$eventName])) {
            throw new \InvalidArgumentException('This event does not correspond to a known flash message');
        }
        
        $this->session->getFlashBag()->add('error', self::$flashMessages[$eventName]);
    }
    
    /**
     * Check if token provided in url for delete an entity is valid
     * 
     * @param AdminCrudEvent $event
     * @throws TokenNotFoundException
     */
    public function checkDeleteToken(AdminCrudEvent $event)
    {
        $submittedToken = $event->getRequest()->query->get('token');
        
        if( !$this->tokenManager->isTokenValid( new CsrfToken('delete-entity', $submittedToken) ) )
        {
            throw new TokenNotFoundException('Token not found');
        }
    }
}
