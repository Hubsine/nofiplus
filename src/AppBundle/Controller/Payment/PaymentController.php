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
    /**
     * @param Request $request
     * @param OrderEntityInterface $order
     */
    public function returnPaymentAction(Request $request, $order)
    {
        // Here create user carte
        
        return new \Symfony\Component\HttpFoundation\Response('Return Payment');
    }
    
    /**
     * @ParamConverter("order", options={"mapping": {"order" = "id"}})
     * 
     * @param Request $request
     * @param OrderEntityInterface $order
     */
    public function cancelPaymentAction(Request $request, $order)
    {
        return $this->render('Cancel Payment');
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