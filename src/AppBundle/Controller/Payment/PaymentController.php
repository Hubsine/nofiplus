<?php

namespace AppBundle\Controller\Payment;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use JMS\Payment\CoreBundle\Model\FinancialTransactionInterface;
use JMS\Payment\CoreBundle\Model\PaymentInterface;
use JMS\Payment\CoreBundle\PluginController\Result;
use AppBundle\Controller\Payment\AbstractPaymentController;
use AppBundle\Entity\Payment\OrderEntityInterface;

/**
 * @author Hubsine <contact@hubsine.com>
 */
class PaymentController extends AbstractPaymentController
{
    const BASE_VIEW_FOLDER  = '@Front/Payment/';
    
    const RETURN_ROUTE      = 'return_payment';
    const CANCEL_ROUTE      = 'cancel_payment';
    const COMPLETE_ROUTE    = 'complete_payment';
    const FAIL_ROUTE        = 'fail_payment';
    const PAYPAL_NOTIFY_ROUTE      = 'notify_paypal_payment';
    
    /**
     * Url de retour après le payment sur le site de paiement. Exemple PayPal.
     * 
     * @ParamConverter("order", class="AppBundle\Entity\Payment\OrderEntityInterface", options={"mapping": {"order" = "id"}})
     * 
     * @param Request $request
     * @param OrderEntityInterface $order
     */
    public function returnPaymentAction(Request $request, $productType, OrderEntityInterface $order)
    {
        // Here create user carte
        return $this->render(self::BASE_VIEW_FOLDER . 'return.html.twig', [
            'order' => $order,
            'array' => (array) $order->getPaymentInstruction()->getPendingTransaction()
        ]);
    }
    
    /**
     * Url de retour en cas d'annulation de paiement
     * 
     * @ParamConverter("order", class="AppBundle\Entity\Payment\OrderEntityInterface", options={"mapping": {"order" = "id"}})
     * 
     * @param Request $request
     * @param OrderEntityInterface $order
     */
    public function cancelPaymentAction(Request $request, $productType, OrderEntityInterface $order)
    {
        return $this->render(self::BASE_VIEW_FOLDER . 'cancel.html.twig');
    }
    
    /**
     * Echec de paiement 
     * 
     * @ParamConverter("order", class="AppBundle\Entity\Payment\OrderEntityInterface", options={"mapping": {"order" = "id"}})
     * 
     * @param Request $request
     * @param OrderEntityInterface $order
     */
    public function failPaymentAction(Request $request, $productType, OrderEntityInterface $order)
    {
        return $this->render(self::BASE_VIEW_FOLDER . 'fail.html.twig');
    }
    
    /**
     * Paiement réussi 
     * 
     * @param Request $request
     * @param OrderEntityInterface $order
     */
    public function completePaymentAction(Request $request, $order)
    {
        return $this->render(self::BASE_VIEW_FOLDER . 'complete.html.twig');
    }
    
    /**
     * 
     * Notification function 
     * @ParamConverter("order", class="AppBundle\Entity\Payment\OrderEntityInterface", options={"mapping": {"order" = "id"}})
     * 
     * @param Request $request
     * @param OrderEntityInterface $order
     */
    public function notifyPayPalPaymentAction(Request $request, $productType, OrderEntityInterface $order)
    {
        // 1 - Retrouver la transaction fiancière concerné
        $financialTransaction    = $order->getPaymentInstruction()->getPendingTransaction();
        
        if ( ! $financialTransaction instanceof FinancialTransactionInterface ) 
        {
            throw new \Exception('Transaction not found');
        }
        
        // 2 - Get payment
        $payment        = $financialTransaction->getPayment();
        
        if( ! $payment instanceof PaymentInterface)
        {
            throw new \Exception('No Payment is associated with the Transaction');
        }
        
         $instruction = $payment->getPaymentInstruction();
         
         $this->applyTransaction($request->request->all(), $payment);
         
         
        return new JsonResponse('ok');
    }
    
    /**
     * "Apply" a transaction by delegating to the PluginController. For the moment,
     * the only supported transactions are 'Completed'.
     *
     * The PluginController will delegate external API calls to the IpnPlugin.
     *
     * @param  array   $notification Key-value parameters sent by paypal
     * @param  Payment $payment      Payment Entity instance
     * @throws Exception If the transaction type is not supported
     * @throws Exception Generic error
     */
    private function applyTransaction ($notification, PaymentInterface $payment)
    {
        $ppc        = $this->get('payment.plugin_controller');
        $result     = null;
        $amount     = 0;
        #$em         = $this->doctrine->getEntityManager();
        #$doctrineUtil = $this->getDoctrineUtil();
        #$repository = $doctrineUtil->getRepository(FinancialTransaction::class);
        
        if (isset($notification['mc_gross'])) {
            $amount = $notification['mc_gross'];
        } else {
            // mc_gross_x
            foreach ($notification as $key => $value) {
                if (strstr($key, 'mc_gross_') !== FALSE) {
                    $amount += $value;
                }
            }
        }
        
        if ($amount === null) 
        {
            throw new \Exception('Invalid amount');
        }
        
        switch ($notification['payment_status']) {
            case 'Pending':
                // The payment is pending. See pending_reason for more information.
                break;
            case 'Completed':
                // The payment has been completed and the funds have been added
                // to the seller's account balance
                if ($payment->getState() === PaymentInterface::STATE_NEW ||
                    $payment->getState() === PaymentInterface::STATE_APPROVING) {
                    $result = $ppc->approveAndDeposit($payment->getId(), $amount);
                }
                break;
//            case 'Refunded':
//                // The seller refunded the payment
//                // HACK
//                // The Payment must have state APPROVED in order for JMSPaymentCore
//                // to accept a credit. Since at this point the payment has state
//                // DEPOSITED, we set it to APPROVED and re-set it back after the
//                // credit was created.
//                $oldState = $payment->getState();
//                $payment->getPaymentInstruction();
//                $this->setPaymentState($payment, PaymentInterface::STATE_APPROVED);
//                // When a transaction is a Refund, Paypal sends a negative amount.
//                // However, we want the credited amount to be a positive number.
//                $amount = abs($amount);
//                try {
//                    $credit = $ppc->createDependentCredit($payment->getId(), $amount);
//                    $result = $ppc->credit($credit->getId(), $amount);
//                } catch (Exception $e) {
//                    $this->setPaymentState($payment, $oldState);
//                    throw $e;
//                }
//                // set the reference number in the newly created transaction
//                $new_transaction = $repository->findOneBy(array('credit' => $credit));
//                if ($new_transaction) {
//                    $new_transaction->setReferenceNumber($notification['txn_id']);
//                    $em->flush($new_transaction);
//                }
//                $this->setPaymentState($payment, $oldState);
//                break;
            default:
                throw new \Exception('Unsupported Transaction: '.$notification['payment_status']);
                break;
        }
        
        if ($result && $result->getStatus() !== Result::STATUS_SUCCESS) {
            throw new \Exception('Transaction was not successful: '.$result->getReasonCode());
        }
    }
}