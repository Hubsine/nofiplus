<?php

namespace AppBundle\Controller\Payment;

use AppBundle\Entity\Payment\OrderEntityInterface;

/**
 *
 * @author Hubsine <contact@hubsine.com>
 */
interface PaymentControllerInterface 
{
    public function paymentCreateAction(OrderEntityInterface $order);
}
