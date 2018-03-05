<?php

namespace AppBundle\Controller\Admin\Traits;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use AppBundle\Exception\ClassNotFoundException;
use AppBundle\AppBundleAdminEvents;
use AppBundle\Entity\AdminEntityInterface;

/**
 * Trait for admin crud action : 
 * - index
 * - new
 * - view
 * - update
 * 
 * @author Hubsine <contact@hubsine.com>
 */
trait EntityCrudTrait 
{
    
    /**
     * Index of 
     * 
     * @return Response
     */
    public function indexAction()
    {
        $entities = $this->getRepository(static::ENTITY)->findAll();
        
        return $this->render($this->getViewFolder('index.html.twig'), array(
            'entities'   => $entities
        ));
    }
    
    /**
     * New
     * 
     * @param Request $request
     * 
     * @return Response
     */
    public function newAction(Request $request)
    {
        /* @var $doctrineUtil \AppBundle\Doctrine\DoctrineUtil */
        $doctrineUtil   = $this->getDoctrineUtil();
        /** @var $user UserInterface */
        $user           = $this->getUser();
        
        $event          = $this->dispatchAdminCrudEvent($user, AppBundleAdminEvents::ADMIN_ENTITY_NEW_INITIALIZE, $request);
        
        $entity         = $this->getEntityOrFormTypeInstance(static::FOR_ENTITY);
        $form           = $this->createForm($this->getEntityOrFormTypeClass(static::FOR_FORM_TYPE), $entity);
        
        $form->handleRequest($request);
        
        if( $form->isSubmitted() )
        {
            if( $form->isValid() )
            {
                $event      = $this->dispatchAdminCrudFormEvent($form, $request, AppBundleAdminEvents::ADMIN_ENTITY_NEW_SUCCESS);
                
                $doctrineUtil->persist($entity);
                
                $response   = $this->getBaseRedirectResponse($event);
                $event      = $this->dispatchAdminCrudFilterUserResponseEvent($user, $request, $response, AppBundleAdminEvents::ADMIN_ENTITY_NEW_COMPLETED);
                
                return $response;
            }
            
            $event          = $this->dispatchAdminCrudFormEvent($form, $request, AppBundleAdminEvents::ADMIN_ENTITY_NEW_FAILURE);
            
            if (null !== $response = $event->getResponse()) {
                return $response;
            }
            
        }
            
        return $this->render($this->getViewFolder( 'new.html.twig' ), array(
            'form'  => $form->createView()
        ));
    }
    
    /**
     * Update 
     * 
     * @ParamConverter("adminEntity", class="AppBundle:AdminEntityInterface")
     * 
     * @param Request $request
     * @param AdminEntityInterface $adminEntity
     * 
     * @return Response
     */
    public function updateAction(Request $request, AdminEntityInterface $adminEntity)
    { 
        /** @var $doctrineUtil \AppBundle\Doctrine\DoctrineUtil */
        $doctrineUtil   = $this->getDoctrineUtil();
        /** @var $user UserInterface */
        $user           = $this->getUser();

        $event = $this->dispatchAdminCrudEvent($user, AppBundleAdminEvents::ADMIN_ENTITY_UPDATE_INITIALIZE, $request);        
        
        $form = $this->createForm($this->getEntityOrFormTypeClass(static::FOR_FORM_TYPE), $adminEntity);
        
        $form->handleRequest($request);
        
        if( $form->isSubmitted() )
        {
            if( $form->isValid() )
            {
                $event      = $this->dispatchAdminCrudFormEvent($form, $request, AppBundleAdminEvents::ADMIN_ENTITY_UPDATE_SUCCESS);
                
                $doctrineUtil->flush();
                
                $response   = $this->getBaseRedirectResponse($event);
                $event      = $this->dispatchAdminCrudFilterUserResponseEvent($user, $request, $response, AppBundleAdminEvents::ADMIN_ENTITY_UPDATE_COMPLETED);
                
                return $response;
            }
            
            $event = $this->dispatchAdminCrudFormEvent($form, $request, AppBundleAdminEvents::ADMIN_ENTITY_UPDATE_FAILURE);
            
            if (null !== $response = $event->getResponse()) {
                return $response;
            }
        }
        
        return $this->render($this->getViewFolder('update.html.twig'), array(
            'form'  => $form->createView()
        ));
    }
    
    /**
     * Delete 
     * 
     * @ParamConverter("adminEntity", class="AppBundle:AdminEntityInterface")
     * 
     * @param AdminEntityInterface $adminEntity
     * 
     * @return Response
     */
    public function deleteAction(Request $request, AdminEntityInterface $adminEntity)
    {
        /** @var $user UserInterface */
        $user           = $this->getUser();
        /** @var $doctrineUtil DoctrineUtil */
        $doctrineUtil   = $this->getDoctrineUtil();
        
        $event          = $this->dispatchAdminCrudEvent($user, AppBundleAdminEvents::ADMIN_ENTITY_DELETE_INITIALIZE, $request);
        
        $doctrineUtil->remove($adminEntity);
        
        $event          = $this->dispatchAdminCrudFormEvent($this->createFormBuilder()->getForm(), $request, AppBundleAdminEvents::ADMIN_ENTITY_DELETE_SUCCESS);
                
        $response       = $this->getBaseRedirectResponse($event);
        $event          = $this->dispatchAdminCrudFilterUserResponseEvent($user, $request, $response, AppBundleAdminEvents::ADMIN_ENTITY_DELETE_COMPLETED);

        return $response;
    }
    
    ###
    # Static function used with self trait
    ###
    
    /**
     * Get entity view folder
     * 
     * @param string $suffix
     * @return string class name
     */
    protected static function getViewFolder($suffix = null)
    {
        return 'AppBundle:Admin\\' . static::FOLDER . ':' . $suffix;
    }
    
    /**
     * Get entity class or form type class
     * 
     * @param int $for
     * 
     * @throws \InvalidArgumentException
     * @throws ClassNotFoundException
     * 
     * @return string Entity class name or form type class name
     */
    protected static function getEntityOrFormTypeClass(int $for)
    {
        if( $for !== 0 && $for !== 1 )
        {
            throw new \InvalidArgumentException('Parameter "$for" must be 0 (for Entity class) or 1 (for EntityFormType class).');
        }
        
        $class  = ($for == 0) ? static::ENTITY : static::TYPE;
        
        if( !class_exists( $class ) )
        {
            throw new ClassNotFoundException($class);
        }
        
        return $class;
    }
    
    /**
     * Get an instance of AdminEntityInterface or FormTypeInterface
     * 
     * @param int $for 
     * @return \AppBundle\Entity\AdminEntityInterface
     */
    protected static function getEntityOrFormTypeInstance(int $for)
    {
        $class  = self::getEntityOrFormTypeClass($for);
        
        return new $class();
    }
    
}
