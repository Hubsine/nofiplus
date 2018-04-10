<?php

namespace AppBundle\EventSubscriber;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use AppBundle\Controller\Front\Pages\PageController;
use AppBundle\Doctrine\DoctrineUtil;
use AppBundle\Entity\Admin\Pages\Maintenance;

/**
 * Description of MaintenanceModeSubscriber
 *
 * @author Hubsine <contact@hubsine.com>
 */
class MaintenanceModeSubscriber implements EventSubscriberInterface
{
    /**
     * @var DoctrineUtil
     */
    private $doctrineUtil;
    
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;
    
    /**
     * @var AuthorizationCheckerInterface
     */
    private $authorizationChecker;
    
    /**
     * @var TwigInterface $twig
     */
    private $twig;
    
    /**
     * @var string
     */
    private $env;

    /**
     * Maintenance Doctrine Entity Page
     * 
     * @var Maintenance
     */
    private $maintenancePage;

    /**
     * Constructor 
     * 
     * @param DoctrineUtil $doctrineUtil
     */
    public function __construct(DoctrineUtil $doctrineUtil, TokenStorageInterface $tokenStorage, AuthorizationCheckerInterface $authorizationChecker,
        \Twig_Environment $twig, $env) 
    {
        $this->doctrineUtil             = $doctrineUtil;
        $this->tokenStorage             = $tokenStorage;
        $this->authorizationChecker     = $authorizationChecker;
        $this->twig                     = $twig;
        $this->env                      = $env;
        
        // On récupère la premiere page de maintenance. Les autres pages de maintenance sont ignorées
        $this->maintenancePage          = $this->doctrineUtil->getRepository(Maintenance::class)->findOneBy(['enable' => true]);
    }

    /**
     * {@inheritdoc}
     */
    static public function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST   => 'onKernelRequest',
        ];
    }
    
    /**
     * onKernelRequest
     * 
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $routeName      = $event->getRequest()->attributes->get('_route');
        $env            = $this->env;
        $isMaintenance  = $this->isMaintenanceMode();
        
        if( $isMaintenance && $env === 'prod' && ! $this->isSuperAdmin() && $routeName !== 'fos_user_security_login' )
        {
        
            $response = $event->getResponse() === null ? new Response() : $event->getResponse();

            $view = $this->getMaintenanceView();

            $response->setContent($view);
            $event->setResponse($response);
        }
    }
    
    /**
     * Check if is maintenance mode 
     * 
     * @return boolean
     */
    private function isMaintenanceMode()
    {
        return $this->maintenancePage instanceof Maintenance ? $this->maintenancePage->getEnable() : false;
    }

    /**
     * Check if is maintenance Mode 
     * 
     * @return boolean
     */
    private function isSuperAdmin()
    {
        return $this->authorizationChecker->isGranted('ROLE_SUPER_ADMIN');
    }
    
    /**
     * Render maintenance mode page view
     * @return string
     */
    private function getMaintenanceView()
    {
        return $this->twig->render(PageController::BASE_VIEW_FOLDER . 'maintenance.html.twig', [
            'page'  => $this->maintenancePage
        ]);
    }
}
