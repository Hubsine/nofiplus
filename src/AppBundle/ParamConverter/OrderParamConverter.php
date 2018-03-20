<?php

namespace AppBundle\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Exception\UnexpectedValueException;
use AppBundle\Entity\Payment\OrderCarte;
use AppBundle\Entity\Payment\OrderEntityInterface;
use AppBundle\Entity\ProductEntityInterface;

/**
 * OrderParamConverter ne converti absolument aucune entity. La class se contente de modifier 
 * la class d'avec la bonne class en se basant sur le paramètre de route productType. 
 * Exemple :
 *  - Foo\Bar\OrderEntityInterface DEVIENT AppBundle\Entity\Payment\OrderCarte
 * 
 * Ensuite le convertisseur doctrine habituel convertie l'entity normalement.
 * 
 * Donc, cette class a vocation à seulement mettre à jour le nom de la class
 *
 * @author Hubsine <contact@hubsine.com>
 */
class OrderParamConverter implements ParamConverterInterface
{
    const OrderEntityInterfaceClass = OrderEntityInterface::class;
    
    public static $productsEntityClass = [
        ProductEntityInterface::PRODUCT_TYPE_CARTE => OrderCarte::class
    ];
 
    /**
     * Doit toujours retourné false afin que DoctrineParamConverter puisse agir par la suite
     * 
     * @param Request $request
     * @param ParamConverter $configuration
     * 
     * @return boolean Return toujours false car le but n'est pas de convertir
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $productType            = $request->attributes->get('productType');
        
        if( !array_key_exists( $productType, self::$productsEntityClass) )
        {
            throw new UnexpectedValueException($productType, self::$productsEntityClass);
        }
        
        $configuration->setClass(self::$productsEntityClass[$productType]);
        
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(ParamConverter $configuration)
    {
        if( $configuration->getClass() === self::OrderEntityInterfaceClass )
        {
            return true;
        }
        
        return false;
    }

}
