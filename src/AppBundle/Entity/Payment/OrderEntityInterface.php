<?php

namespace AppBundle\Entity\Payment;

use JMS\Payment\CoreBundle\Model\PaymentInstructionInterface;

/**
 * Description of OrderEntityInterface
 *
 * @author Hubsine <contact@hubsine.com>
 */
interface OrderEntityInterface 
{
    public function getPaymentInstruction() : PaymentInstructionInterface;
}
