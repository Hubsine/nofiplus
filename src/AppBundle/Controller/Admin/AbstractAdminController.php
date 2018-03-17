<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Controller\Controller as BaseController;
use AppBundle\Event\Admin\AdminCrudFormEvent;
use AppBundle\Controller\Admin\Traits\EventDispatcherTrait;
use AppBundle\Controller\Admin\Traits\EntityCrudTrait;

/**
 * Description of AbstractAdminController
 *
 * @author Hubsine <contact@hubsine.com>
 */
class AbstractAdminController extends BaseController
{
    const FOR_ENTITY        = 0;
    const FOR_FORM_TYPE     = 1;
    
    use EventDispatcherTrait;
    use EntityCrudTrait;
    
    /**
     * Get redirect response in form success
     * 
     * @param AdminCrudFormEvent $event
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function getBaseRedirectResponse(AdminCrudFormEvent $event)
    {
        return ( null === $response = $event->getResponse() ) ? $this->redirectToRoute(static::BASE_ROUTE) : $event->getResponse();
    }
}
