<?php

namespace AppBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use AppBundle\Doctrine\DoctrineUtil;
use AppBundle\Entity\Admin\Pages\Page;

/**
 * Description of PagesQuerySubscriber
 *
 * @author Hubsine <contact@hubsine.com>
 */
class PagesQuerySubscriber implements EventSubscriberInterface
{
    /**
     * @var DoctrineUtil
     */
    private $doctrineUtil;
    
    /**
     * Constructor 
     * 
     * @param DoctrineUtil $doctrineUtil
     */
    public function __construct(DoctrineUtil $doctrineUtil) 
    {
        $this->doctrineUtil = $doctrineUtil;
    }

    /**
     * {@inheritdoc}
     */
    static public function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest'
        ];
    }
    
    /**
     * onKernelRequest
     * 
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request    = $event->getRequest();

        $pages      = $this->doctrineUtil->getRepository(Page::class)->findBy([], ['createdAt'=> 'desc']);
        
        $request->attributes->add(['pages'  => $pages]);
    }
}
