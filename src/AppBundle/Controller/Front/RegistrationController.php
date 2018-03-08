<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller\Front;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use AppBundle\Controller\Controller;
use AppBundle\Exception\UnexpectedValueException;
use AppBundle\Entity\User\User;
use AppBundle\Entity\User\Partner\Partner;
use AppBundle\Entity\User\Abonne\Abonne;
use AppBundle\Form\Type\User\RegistrationPartnerType;
use AppBundle\Form\Type\User\RegistrationType;

/**
 * Controller managing the registration.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 * @author Christophe Coevoet <stof@notk.org>
 */
class RegistrationController extends Controller
{
    
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function registerAction(Request $request, $asuser)
    {
        /** @var $formFactory FactoryInterface */
        $formFactory = $this->get('fos_user.registration.form.factory');
        /** @var $userManager UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        #$user = $this->getUserTypeEntityFromRequest($request);
        $user = $this->getAsUserEntity();
        $user->setEnabled(true);

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        #$form = $formFactory->createForm();
        $form = $this->getAsUserRegistrationFormType();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isSubmitted()) 
        {
            $user instanceof Partner ? $user->setEnabledByAdmin(false) : $user->setEnabledByAdmin(true);
            
            if ($form->isValid()) 
            {
                
                $event = new FormEvent($form, $request);
                
                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);
                
                $event->setResponse($this->redirectToRoute('fos_user_registration_check_email', ['asuser'=>$asuser]));
                
                $this->getDoctrineUtil()->persist($user);

                if (null === $response = $event->getResponse()) {
                    $url = $this->generateUrl('fos_user_registration_confirmed', array('asuser' => $asuser));
                    $response = new RedirectResponse($url);
                }

                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

                return $response;
            }

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_FAILURE, $event);

            if (null !== $response = $event->getResponse()) {
                return $response;
            }
        }

        return $this->render('@Front/User/Registration/register.html.twig', array(
            'form' => $form->createView(),
            'asUser'  => $asuser
        ));
    }

    /**
     * Tell the user to check their email provider.
     */
    public function checkEmailAction()
    {
        $email = $this->get('session')->get('fos_user_send_confirmation_email/email');

        if (empty($email)) 
        {
            return new RedirectResponse($this->get('router')->generate('fos_user_registration_register', array('asuser' => $this->getAsUserType()) ));
        }

        $this->get('session')->remove('fos_user_send_confirmation_email/email');
        
        $user = $this->getDoctrineUtil()
                ->getRepository( $this->getAsUserEntityClassName() )
                ->findOneByEmail($email);

        if (null === $user) 
        {
            throw new NotFoundHttpException(sprintf('The user with email "%s" does not exist', $email));
        }

        return $this->render('@Front/User/Registration/check_email.html.twig', array(
            'user' => $user
        ));
    }

    /**
     * Receive the confirmation token from user email provider, login the user.
     *
     * @param Request $request
     * @param string  $token
     *
     * @return Response
     */
    public function confirmAction(Request $request, $token)
    {
        $doctrineUtil   = $this->getDoctrineUtil();

        $user   = $doctrineUtil->getRepository( $this->getAsUserEntityClassName() )->findOneByConfirmationToken($token);
        
        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with confirmation token "%s" does not exist', $token));
        }

        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');
        /** @var $aclSecurityManager AppBundle\Security\AclSecurityManager */
        $aclSecurityManager = $this->get('app.security.acl_manager');

        $user->setConfirmationToken(null);
        $user->setEnabled(true);

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_CONFIRM, $event);

        $doctrineUtil->persist($user);
        
        if (null === $response = $event->getResponse()) {
            $url = $this->generateUrl('fos_user_registration_confirmed', array('asuser'  => $this->getAsUserType($request)));
            $response = new RedirectResponse($url);
        }

        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_CONFIRMED, new FilterUserResponseEvent($user, $request, $response));
        
        $maskBuilder = new MaskBuilder();
        
        $maskBuilder->add('OPERATOR');
        
        $aclSecurityManager->insertObjectAce($user, $maskBuilder);

        return $response;
    }

    /**
     * Tell the user his account is now confirmed.
     */
    public function confirmedAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        return $this->render('@Front/User/Registration/confirmed.html.twig', array(
            'user' => $user,
            'targetUrl' => $this->getTargetUrlFromSession(),
        ));
    }

    /**
     * @return mixed
     */
    private function getTargetUrlFromSession()
    {
        $key = sprintf('_security.%s.target_path', $this->get('security.token_storage')->getToken()->getProviderKey());

        if ($this->get('session')->has($key)) {
            return $this->get('session')->get($key);
        }
    }
    
    /**
     * Get user type from request. Are abonne or partner
     * 
     * @param Request $request
     * @return string
     * @throws UnexpectedValueException
     */
    private function getAsUserType(Request $request = null): string
    {
        $request = null === $request ? $this->get('request_stack')->getCurrentRequest() : $request;
        
        $avaibleAsUsers   = array(User::ABONNE_TYPE, User::PARTNER_TYPE);
        $asUser           = $request->attributes->get('asuser');
        
        if( ! in_array($asUser, $avaibleAsUsers) )
        {
            throw new UnexpectedValueException($asUser, $avaibleAsUsers);
        }
        
        return $asUser;
    }
    
    /**
     * Get form for user abonne or partner 
     * 
     * @param Request $request
     * @return \Symfony\Component\Form\FormInterface;
     * @throws UnexpectedValueException
     */
    protected function getAsUserRegistrationFormType(Request $request = null)
    {
        $asUser                   = $this->getAsUserType($request);
        
        switch ( $asUser )
        {
            case User::PARTNER_TYPE:
                $form = $this->createForm(RegistrationPartnerType::class);    
                break;
            
            default:
                $form = $this->createForm(RegistrationType::class);   
        }
        
        return $form;
    }
    
    /**
     * Get user entity by user type
     * 
     * @param Request $request
     * @return mixed
     */
    protected function getAsUserEntity(Request $request = null)
    {
        $asUser = $this->getAsUserType($request);
        
        switch ( $asUser )
        {
            case User::PARTNER_TYPE:
                $user   = new Partner();
                break;
            
            default :
                $user   = new Abonne();
        }
        
        return $user;
    }
    
    /**
     * Get entity class name by user 
     * 
     * @param Request $request
     * @return string User class name
     */
    protected function getAsUserEntityClassName(Request $request = null)
    {
        $asUser = $this->getAsUserType($request);
        
        switch ( $asUser )
        {
            case User::PARTNER_TYPE:
                return Partner::class;
                break;
            
            default :
                return Abonne::class;
        }
    }
}
