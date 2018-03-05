<?php

namespace AppBundle\Twig\Extensions;

use Symfony\Component\Security\Core\Exception\InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormView;
use Symfony\Component\Templating\EngineInterface;

/**
 * Description of SimpleFormExtension
 *
 * @author Hubsine <contact@hubsine.com>
 */
class SimpleFormExtension extends \Twig_Extension
{
    const SIMPLE_FORM_TEMPLATE = 'Snippet/simple_form.html.twig';
    const AVAIBLES_ADMIN_ACTION = array('new', 'update', 'delete');

    /**
     *
     * @var TwigEngine $twig
     */
    private $twig;
    
    /**
     * Constructor
     * 
     * @param EngineInterface $twig
     */
    public function __construct(EngineInterface $twig) 
    {
        $this->twig = $twig;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('simpleForm', array($this, 'simpleForm')),
        );
    }
    
    /**
     * Create a html form view 
     * 
     * @param FormView $form
     * @param string $formAction
     * @param string $adminAction
     * @param array $pathParameters 
     * @param string $formMethod
     * 
     * @return string
     */
    public function simpleForm(FormView $form, $formAction, $adminAction, $pathParameters = array(), $formMethod = null)
    {
        if( !in_array($adminAction, self::AVAIBLES_ADMIN_ACTION) )
        {
            throw new InvalidArgumentException('Admin action must be "new", "update" or "delete"');
        }
        
        $formMethod = ( empty($formMethod) ) ? 'POST' : $formMethod;
        
        return $this->twig->render(self::SIMPLE_FORM_TEMPLATE, array(
            'form'   => $form,
            'formAction' => $formAction,
            'adminAction'   => $adminAction,
            'pathParameters'    => $pathParameters,
            'formMethod' => $formMethod
        ));
    }
}
