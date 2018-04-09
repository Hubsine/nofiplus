<?php

namespace AppBundle\Entity\Payment;

use JMS\Payment\CoreBundle\Model\PaymentInstructionInterface;
use AppBundle\Entity\ProductEntityInterface;

/**
 * Description of OrderEntityInterface
 *
 * @author Hubsine <contact@hubsine.com>
 */
interface OrderEntityInterface 
{
    public function getPaymentInstruction();
    
    /**
     * Get product
     */
    public function getProduct() : ProductEntityInterface;
    
    /**
     * Set product
     * 
     * @param ProductEntityInterface $product
     * @return OrderEntityInterface
     */
    public function setProduct(ProductEntityInterface $product);
}
