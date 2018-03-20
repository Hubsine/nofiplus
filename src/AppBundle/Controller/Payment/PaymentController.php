<?php

namespace AppBundle\Controller\Payment;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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
    const NOTIFY_ROUTE      = 'notify_payment';
    
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
        $paymentStatus  = $order->getPaymentInstruction()->getState();
        
        // Here create user carte
        return $this->render(self::BASE_VIEW_FOLDER . 'return.html.twig', [
            'order' => $order
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
        // IPN Data from paypal
        $postData     = $request->request;
        $payment        = $order->getPaymentInstruction()->getPayments();
        
        $paymentStatus = $postData['payment_status'];
        
        if( strtolower($paymentStatus) === 'complere')
        {
            $order->getPaymentInstruction()->setState($state);
        }
        return new JsonResponse('ok');
    }
    
    /**
     * @param Request $request
     * @param OrderEntityInterface $order
     */
    public function notifyPayPalIpnPaymentAction()
    {
        return new \Symfony\Component\HttpFoundation\JsonResponse('OK');
    }
}