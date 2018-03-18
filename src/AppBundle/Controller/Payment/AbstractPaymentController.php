<?php

namespace AppBundle\Controller\Payment;

use JMS\Payment\CoreBundle\Model\PaymentInterface;
use JMS\Payment\CoreBundle\PluginController\Result;
use AppBundle\Controller\Controller as BaseController;
use AppBundle\Entity\Payment\OrderEntityInterface;
use AppBundle\Exception\BadInstanceException;

/**
 * Description of AbstractPaymentController
 *
 * @author Hubsine <contact@hubsine.com>
 */
abstract class AbstractPaymentController extends BaseController
{
    protected function isOrder($order)
    {
        if( ! $order instanceof OrderEntityInterface )
        {
            throw new BadInstanceException(get_class($order), OrderEntityInterface::class);
        }
    }
    
    /**
     * 
     * @param type $order
     * @return PaymentInterface
     */
    protected function createPayment($order)
    {
        $this->isOrder($order);
            
        $instruction = $order->getPaymentInstruction();
        $pendingTransaction = $instruction->getPendingTransaction();

        if ($pendingTransaction !== null) {
            return $pendingTransaction->getPayment();
        }

        $ppc = $this->get('payment.plugin_controller');
        $amount = $instruction->getAmount() - $instruction->getDepositedAmount();

        return $ppc->createPayment($instruction->getId(), $amount);
    }
    
    /**
     * 
     * @param PaymentInterface $payment
     * @return Result
     */
    protected function getResult(PaymentInterface $payment)
    {
        $ppc = $this->get('payment.plugin_controller');
        return $result = $ppc->approveAndDeposit($payment->getId(), $payment->getTargetAmount());
    }
}
