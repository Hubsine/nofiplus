<?php

namespace AppBundle\Twig\Extensions;

use Symfony\Component\Templating\EngineInterface;
use AppBundle\Entity\AdminEntityInterface;

/**
 * Description of SimpleSnippetExtension
 *
 * @author Hubsine <contact@hubsine.com>
 */
class SimpleSnippetExtension extends \Twig_Extension
{
 
    /**
     * @var TwigInterface $twig
     */
    private $twig;
    
    /**
     * Constructor
     * 
     * @param EngineInterface $twig
     */
    public function __construct(EngineInterface $twig) 
    {
        $this->twig         = $twig;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('renderSnippetNew',        array($this, 'renderSnippetNew')),
            new \Twig_SimpleFunction('renderSnippetUpdate',     array($this, 'renderSnippetUpdate')),
            new \Twig_SimpleFunction('renderSnippetDelete',     array($this, 'renderSnippetDelete'))
        );
    }
    
    /**
     * Render snippet 
     * 
     * @param string $template
     * @param array $parameters
     * @return string A rendered string view
     */
    protected function renderSnippet($template, array $parameters = array())
    {
        return $this->twig->render($template, $parameters);
    }
    
    /**
     * Get complete route name for crud entity
     * 
     * @param AdminEntityInterface $object
     * @param string $action
     * @return string
     */
    protected function getCompleteRouteName(AdminEntityInterface $object, $action)
    {
        return $routeName = $object->getRoutePrefix() . '_' . $action;
    }
    
    /**
     * Render snippet new.html.twig
     * 
     * @param string $routeName
     * @param array $routeParameters
     * @return string render view string
     */
    public function renderSnippetNew($routeName, array $routeParameters = array())
    {
        return $this->renderSnippet('@App/Snippet/new.html.twig', array(
            'routeName' => $routeName,
            'routeParameters'   => $routeParameters
        ));
    }
    
    /**
     * Render snippet update.html.twig
     * 
     * @param string $routeName
     * @param array $routeParameters
     * @return string A rendered string view
     */
    public function renderSnippetUpdate($routeName, array $routeParameters = array())
    {
        return $this->renderSnippet('@App/Snippet/update.html.twig', array(
            'routeName' => $routeName,
            'routeParameters'   => $routeParameters
        ));
    }
    
    /**
     * Render snippet delete.html.twig
     * 
     * @param string $routeName
     * @param array $routeParameters
     * @return string A rendered string view
     */
    public function renderSnippetDelete($routeName, array $routeParameters = array())
    {
        return $this->renderSnippet('@App/Snippet/delete.html.twig', array(
            'routeName' => $routeName,
            'routeParameters'   => $routeParameters
        ));
    }
}
