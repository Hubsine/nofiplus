<?php

namespace AppBundle\Controller\Payment;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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
     * Url de retour après le payment sur PayPal 
     * 
     * @param Request $request
     * @param OrderEntityInterface $order
     */
    public function returnPaymentAction(Request $request, $order)
    {
        // Here create user carte
        
        return $this->render(self::BASE_VIEW_FOLDER . 'return.html.twig');
    }
    
    /**
     * Url de retour en cas d'annulation de paiement
     * 
     * @param Request $request
     * @param OrderEntityInterface $order
     */
    public function cancelPaymentAction(Request $request, $order)
    {
        return $this->render(self::BASE_VIEW_FOLDER . 'cancel.html.twig');
    }
    
    /**
     * Echec de paiement 
     * 
     * @param Request $request
     * @param OrderEntityInterface $order
     */
    public function failPaymentAction(Request $request, $order)
    {
        return $this->render(self::BASE_VIEW_FOLDER . 'complete.html.twig');
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
     * @ParamConverter("order", options={"mapping": {"order" = "id"}})
     * 
     * @param Request $request
     * @param OrderEntityInterface $order
     */
    public function notifyPaymentAction(Request $request, $order)
    {
        return $this->render('Cancel Payment');
    }
    
}