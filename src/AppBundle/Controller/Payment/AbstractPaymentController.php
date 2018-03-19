<?php

namespace AppBundle\Controller\Payment;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use JMS\Payment\CoreBundle\Model\PaymentInterface;
use JMS\Payment\CoreBundle\PluginController\Result;
use JMS\Payment\CoreBundle\Form\ChoosePaymentMethodType;
use AppBundle\Controller\Controller as BaseController;
use AppBundle\Entity\Payment\OrderEntityInterface;
use AppBundle\Exception\BadInstanceException;
use AppBundle\Exception\UndefinedFunctionException;
use AppBundle\Exception\InvalidTypeException;

/**
 * Description of AbstractPaymentController
 *
 * @author Hubsine <contact@hubsine.com>
 */
abstract class AbstractPaymentController extends BaseController
{
    /**
     * Check if object implement OrderEntityInterface class
     * 
     * @param OrderEntityInterface $order
     * @throws BadInstanceException
     */
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
    
    /**
     * Create a ChoosePaymentMethodType form 
     * 
     * @param OrderEntityInterface $order
     * @return FormInterface
     */
    protected function createPaymentMethodForm(OrderEntityInterface $order)
    {
        if( ! method_exists( $order, 'getId' ) )
        {
            throw new UndefinedFunctionException('getId()', get_class($order));
        }
        
        if( ! is_integer( $order->getId() ) )
        {
            throw new InvalidTypeException( gettype( $order->getId() ), 'integer');
        }
        
        $address    = $order->getUser()->getAddress();
        $user       = $order->getUser();
        $carte      = $order->getCarte();
        
        $config = [
            'paypal_express_checkout' => [
                'return_url' => $this->generateUrl('return_payment', [
                    'order' => $order->getId(),
                ], UrlGeneratorInterface::ABSOLUTE_URL),
                'cancel_url' => $this->generateUrl('cancel_payment', [
                    'order' => $order->getId(),
                ], UrlGeneratorInterface::ABSOLUTE_URL),
                'notify_url' => $this->generateUrl('notify_payment', [
                    'order' => $order->getId(),
                ], UrlGeneratorInterface::ABSOLUTE_URL),
                'useraction'                        => 'commit',
                'checkout_params' => [
                    'PAYMENTREQUEST_0_SHIPTONAME'       => $user->getFirstName() . ' ' . $user->getLastName(),
                    'PAYMENTREQUEST_0_EMAIL'            => $user->getEmail(),
                    'L_PAYMENTREQUEST_0_NAME0'          => $carte->getName(),
                    'L_PAYMENTREQUEST_0_NUMBER0'        => 1,
                    'L_PAYMENTREQUEST_0_AMT0'           => $order->getAmount(),
                    'L_PAYMENTREQUEST_0_QTY0'           => 1,
                    'L_PAYMENTREQUEST_0_DESC0'          => $carte->getAbout(),
                    'ADDROVERRIDE'                      => 1, # Override shipping address
                    'PAYMENTREQUEST_0_SHIPTOSTREET'     => $address->getAddress(),
                    'PAYMENTREQUEST_0_SHIPTOCITY'       => $address->getCity(),
                    #'PAYMENTREQUEST_0_SHIPTOSTATE'      =>'CA',
                    'PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE'=> $address->getCountry(),
                    'PAYMENTREQUEST_0_SHIPTOZIP'        => $address->getZipCode()
                ]
            ],
        ];
        
        $form = $this->createForm(ChoosePaymentMethodType::class, null, [
            'amount'   => $order->getAmount(),
            'currency' => 'EUR',
            'predefined_data'   => $config,
            'default_method'    => 'paypal_express_checkout',
            'allowed_methods' => ['paypal_express_checkout'],
            'method_options' => [
                'paypal_express_checkout' => [
                    'label' => false
                ],
            ],
            'allow_extra_fields'    => true
        ]);
        
        return $form;
    }
    
}
