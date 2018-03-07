<?php

namespace AppBundle\Controller\Front;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use AppBundle\Controller\Controller;
use AppBundle\Entity\User\User;
use AppBundle\Entity\User\Avatar;
use AppBundle\Entity\Address;
use AppBundle\Entity\Admin\SocialNetworkAvaible;
use AppBundle\AppBundleEvents;
use AppBundle\Event\UploadMediaEvent;
use AppBundle\Event\FormCollectionEvent;
use AppBundle\Form\Type\User\ParametersType;

class ProfilesController extends Controller
{
    /**
     * 
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $repo = $this->get('app.doctrine.util')->getRepository(User::class);
        
        $query = $repo->appFindAll();
        
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            15/*limit per page*/
        );
        
        return $this->render('@Front/User/Profiles/index.html.twig', array(
            'pagination'    => $pagination
        ));
    }
    
    /**
     * 
     * @param User $user
     * 
     * @return Response
     */
    public function showAction(User $user)
    {
        return $this->render('@Front/User/Profiles/show.html.twig', array(
            "user"  => $this->getDoctrineUtil()->getRepository(User::class)->findAllJoinByUser($user->getId())
        ));
    }
    
    /**
     * Update User profile data
     * 
     * @param Request $request
     * @param User $user
     * 
     * @return Response
     */
    public function updateAction(Request $request, User $user)
    {
        $this->isGrantedWithDeny('EDIT', $user);
       
        if ( !is_object($user) || !$user instanceof UserInterface ) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->getEventDispatcher();
        /* @var $mediaUtil \AppBundle\Util\MediaUtil */
        $mediaUtil      = $this->get('app.util.media');   

        $lastUsername   = $user->getUsername();

        ###
        # Events
        ###
        $formCollectionEvent    = new FormCollectionEvent($user->getSocialNetworks(), new ArrayCollection());
        $dispatcher->dispatch(AppBundleEvents::FORM_COLLECTION_INITIALIZE, $formCollectionEvent);
        $originalSocialNeworks   = $formCollectionEvent->getNewArrayCollection();
        
        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }
        ###
        # End Events
        ###
        
        /** @var $formFactory FactoryInterface */
        $formFactory = $this->get('fos_user.profile.form.factory');

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);
        
        $collectionMax = $this->getDoctrineUtil()->getRepository(SocialNetworkAvaible::class)->getCount();

        if ($form->isSubmitted() && $form->isValid()) {
            
            /** @var $userManager UserManagerInterface */
            $userManager = $this->get('fos_user.user_manager');

            $formCollectionEvent    = new FormCollectionEvent($originalSocialNeworks, $user->getSocialNetworks());
            $dispatcher->dispatch(AppBundleEvents::FORM_COLLECTION_SUCCESS, $formCollectionEvent);
            
            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_SUCCESS, $event);

            // Avatar
            $avatar = $user->getAvatar();
            if( $mediaUtil->isUploadedFile( $avatar ) )
            {
                $mediaUtil->markEntityToUpload($avatar);

                $uploadEvent = new UploadMediaEvent(array($avatar));
                $this->getEventDispatcher()->dispatch(AppBundleEvents::UPLOAD_MEDIA_INITIALIZE, $uploadEvent);
            }

            $userManager->updateUser($user);
            
            // Update Acl if username is changed
            $this->getAclManager()->updateUserSecurityIdentity($user, $lastUsername);
            
            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl(User::getRoutePrefix() . '_edit', array('slug' => $user->getSlug()));
                $response = new RedirectResponse($url);
            }

            $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_COMPLETED, new FilterUserResponseEvent($user, $request, $response));
            $dispatcher->dispatch(AppBundleEvents::UPLOAD_MEDIA_COMPLETED, new UploadMediaEvent());

            return $response;
        }
        
        return $this->render('@Front/User/Profiles/edit.html.twig', array(
            'form'  => $form->createView(),
            'user'  => $user, 
            'collectionMax' => $collectionMax
            
        ));
    }
    
    /**
     * Update User profile parameters data
     * 
     * @param Request $request
     * @param User $user
     * 
     * @return Response
     */
    public function updateParametersAction(Request $request, User $user)
    {
        $this->isGrantedWithDeny('EDIT', $user);
       
        if ( !is_object($user) || !$user instanceof UserInterface ) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }
        
        /** @var $formFactory FactoryInterface */
        $formFactory = $this->get('fos_user.profile.form.factory');

        $form = $this->createForm(ParametersType::class, $user);
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            /** @var $userManager UserManagerInterface */
            $userManager = $this->get('fos_user.user_manager');

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_SUCCESS, $event);

            $userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl(User::getRoutePrefix() . '_edit', array('slug' => $user->getSlug()));
                $response = new RedirectResponse($url);
            }

            $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }
        
        return $this->render('@Front/User/Profiles/edit_parameters.html.twig', array(
            'form'  => $form->createView(),
            'user'  => $user
        ));
    }
}
