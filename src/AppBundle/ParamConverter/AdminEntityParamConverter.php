<?php

namespace AppBundle\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Prophecy\Exception\Doubler\ClassNotFoundException;

/**
 * AdminEntityParamConverter ne converti absolument aucune entity. La class se contente de modifier 
 * le ParamConverter avec le bon nom et la bonne class :
 *  - adminEntityInterface DEVIENT nomDeEntity
 *  - AppBundle:AdminEntityInterface DEVIENT AppBundle:Admin\ClassDeEntity
 * 
 * Ensuite le convertisseur doctrine habituel convertie l'entity normalement.
 * 
 * Donc, cette class a vocation à seulement mettre à jour le param converter 
 *
 * @author Hubsine <contact@hubsine.com>
 */
class AdminEntityParamConverter implements ParamConverterInterface
{
    const ADMIN_CLASS = 'AppBundle:AdminEntityInterface';
 
    /**
     * Doit toujours retourné false afin que DoctrineParamConverter puisse agir
     * 
     * @param Request $request
     * @param ParamConverter $configuration
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $controllerAction       = $request->attributes->get('_controller');
        $cData                  = explode('::', $controllerAction);
        
        list($cName, $cMethod) = $cData;
        
        if( !class_exists($cName) )
        {
            throw new ClassNotFoundException(sprintf('Class controller "%s" not found.', $cName), $cName);
        }
        
        $refClass = new \ReflectionClass($cName);
        
        $configuration->setClass($refClass->getConstant('ENTITY'));
        
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(ParamConverter $configuration)
    {
        if( $configuration->getClass() === self::ADMIN_CLASS )
        {
            return true;
        }
        
        return false;
    }

}
