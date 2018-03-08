<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use AppBundle\Util\RouteUtil;
use AppBundle\Menu\MenuTrait;

/**
 * Description of AbstractMenuBuilder
 *
 * @author Hubsine <contact@hubsine.com>
 */
abstract class AbstractMenuBuilder 
{
 
    use MenuTrait;
    
    /**
     * @var \Knp\Menu\FactoryInterface
     */
    protected $factory;
    
    /**
     * @var \Symfony\Component\HttpFoundation\RequestStack
     */
    protected $requestStack;
    
    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;
    
    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;
    
    /**
     * @var AuthorizationCheckerInterface
     */
    protected $authorizationChecker;
    
    /**
     * @var RouteUtil
     */
    protected $routeUtil;

    /**
     * Constructor 
     * 
     * @param TokenInterface $factory
     */
    public function __construct(FactoryInterface $factory, RequestStack $requestStack, TokenStorageInterface $tokenStorage,
            AuthorizationCheckerInterface $authorizationChecker, RouteUtil $routeUtil)
    {
        $this->factory              = $factory;
        $this->requestStack         = $requestStack;
        $this->request              = $requestStack->getCurrentRequest();
        $this->tokenStorage         = $tokenStorage;
        $this->authorizationChecker = $authorizationChecker;
        $this->routeUtil            = $routeUtil;
    }
    
    /**
     * Check if current user is equal to request user
     * Can be used to show MenuItem element 
     * 
     * @return boolean
     */
    protected function showItemForCurrentUser()
    {
        $requestUser    = $this->request->attributes->get('user');
        
        return $this->authorizationChecker->isGranted('EDIT', $requestUser);
    }
}
