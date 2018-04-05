<?php

namespace AppBundle\Mailer;

use FOS\UserBundle\Mailer\TwigSwiftMailer as BaseTwigSwiftMailer;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use AppBundle\Entity\User\User;
use AppBundle\Entity\User\Partner\Partner;
use AppBundle\Entity\User\Abonne\Abonne;
use AppBundle\Entity\Contact;
use AppBundle\Exception\BadInstanceException;

/**
 * @author Christophe Coevoet <stof@notk.org>
 */
class TwigSwiftMailer extends BaseTwigSwiftMailer
{

    /**
     * TwigSwiftMailer constructor.
     *
     * @param \Swift_Mailer         $mailer
     * @param UrlGeneratorInterface $router
     * @param \Twig_Environment     $twig
     * @param array                 $parameters
     */
    public function __construct(\Swift_Mailer $mailer, UrlGeneratorInterface $router, \Twig_Environment $twig, array $parameters)
    {
        parent::__construct($mailer, $router, $twig, $parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function sendConfirmationEmailMessage(UserInterface $user)
    {
        $template = $this->parameters['template']['confirmation'];
        
        $url = $this->router->generate('fos_user_registration_confirm', 
                array( 
                    'token' => $user->getConfirmationToken(), 
                    'asuser'  => $this->getAsUserType($user) 
                ), 
                UrlGeneratorInterface::ABSOLUTE_URL);

        $context = array(
            'user' => $user,
            'confirmationUrl' => $url,
            'asUser'    => $this->getAsUserType($user)
        );

        $this->sendMessage($template, $context, $this->parameters['from_email']['confirmation'], (string) $user->getEmail());
    }

    /**
     * {@inheritdoc}
     */
    public function sendResettingEmailMessage(UserInterface $user)
    {
        $template = $this->parameters['template']['resetting'];
        $url = $this->router->generate('fos_user_resetting_reset', 
            array(
                'token' => $user->getConfirmationToken(),
                'asuser'    => $this->getAsUserType($user)
            ), 
            UrlGeneratorInterface::ABSOLUTE_URL);

        $context = array(
            'user' => $user,
            'confirmationUrl' => $url,
            'asUser'    => $this->getAsUserType($user)
        );

        $this->sendMessage($template, $context, $this->parameters['from_email']['resetting'], (string) $user->getEmail());
    }
    
    public function sendContactMessage(Contact $contact)
    {
        $template   = $this->parameters['template']['contact'];
        $fromEmail  = $this->parameters['from_email']['contact'];
        
        $fromSenderEmail  = $contact->getFromEmail();
        $fromSenderName   = $contact->getFromName();
        
        $context    = [
            'subject'   => $contact->getSubject(),
            'message'   => $contact->getMessage()
        ];
        
        $this->sendMessage($template, $context, [$fromEmail => 'Contact - NOFI Plus'], $fromEmail, [$fromSenderEmail  => $fromSenderName]);
    }

    /**
     * @param string $templateName
     * @param array  $context
     * @param array  $fromEmail
     * @param strin|array $toEmail
     */
    protected function sendMessage($templateName, $context, $fromEmail, $toEmail, $replyTo = [])
    {
        $template = $this->twig->load($templateName);
        $subject = $template->renderBlock('subject', $context);
        $textBody = $template->renderBlock('body_text', $context);

        $htmlBody = '';

        if ($template->hasBlock('body_html', $context)) {
            $htmlBody = $template->renderBlock('body_html', $context);
        }

        $message = (new \Swift_Message())
            ->setSubject($subject)
            ->setFrom($fromEmail)
            ->setTo($toEmail)
            ->setReplyTo($replyTo);

        if (!empty($htmlBody)) {
            $message->setBody($htmlBody, 'text/html')
                ->addPart($textBody, 'text/plain');
        } else {
            $message->setBody($textBody);
        }

        $this->mailer->send($message);
    }
    
    /**
     * Get as user. Must be User::PARTNER_TYPE or User::ABONNE_TYPE
     * 
     * @param UserInterface $user
     * @return string
     * @throws BadInstanceException
     */
    public function getAsUserType(UserInterface $user)
    {
        if( $user instanceof Partner ) return User::PARTNER_TYPE;
        
        if( $user instanceof Abonne ) return User::ABONNE_TYPE;
        
        throw new BadInstanceException( get_class($user), 'Abonne, Partner' );
    }
}
