<?php

namespace AppBundle\Controller\Payment;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use JMS\Payment\CoreBundle\Plugin\Exception\Action\VisitUrl;
use JMS\Payment\CoreBundle\Plugin\Exception\ActionRequiredException;
use JMS\Payment\CoreBundle\PluginController\Result;
use AppBundle\Controller\Payment\AbstractPaymentController;
use AppBundle\Controller\Payment\PaymentControllerInterface;
use AppBundle\Entity\Payment\OrderEntityInterface;
use AppBundle\Entity\ProductEntityInterface;
use AppBundle\Controller\Payment\PaymentController;
use AppBundle\Entity\Admin\Category\Carte;
use AppBundle\Entity\Payment\OrderCarte;
use AppBundle\Entity\User\Abonne\Abonne;
use AppBundle\Form\Type\Payment\OrderCarteType;
use AppBundle\Exception\InvalidObjectValuesException;

/**
 * @author Hubsine <contact@hubsine.com>
 */
class OrderCarteController extends AbstractPaymentController implements PaymentControllerInterface
{
    const BASE_VIEW_FOLDER  = '@Front/Payment/OrderCarte/';
    
    /**
     * @ParamConverter("carte", options={"mapping": {"carte": "slug"}})
     * @param Carte $carte
     * 
     * @return RedirectResponse
     */
    public function newAction(Carte $carte)
    {
        $user = $this->getUser();
                
        if( ! $user instanceof Abonne )
        {
            throw $this->createAccessDeniedException();
        }
        
        $pendingOrderCarte = $this->getDoctrineUtil()->getRepository(OrderCarte::class)->findOneBy([
            'user'  => $user->getId(),
            'carte' => $carte->getId(), 
            'paymentInstruction'    => null
        ]);
        
        $orderCarte = ( ! $pendingOrderCarte instanceof OrderCarte ) ? new OrderCarte() : $pendingOrderCarte;
        
        $orderCarte->setAmount($carte->getAmount());
        $orderCarte->setCarte($carte);
        $orderCarte->setUser($this->getUser());
        
        $errors = $this->get('validator')->validate($orderCarte, null, ['new']);
        
        if( count($errors) > 0 )
        {
            throw new InvalidObjectValuesException( get_class( $orderCarte ) );
        }
    
        ( is_integer( $orderCarte->getId() ) ) ? $this->getDoctrineUtil()->flush() : $this->getDoctrineUtil()->persist($orderCarte);
        
        return $this->redirectToRoute($this->getCompleteRoute(OrderCarte::class, 'show'), [
            'order' => $orderCarte->getId()
        ]);
    }
    
    /**
     * @ParamConverter("orderCarte", options={"mapping": {"order" = "id"}})
     * 
     * @param Request $request
     * @param OrderCarte $orderCarte
     * @return Response
     */
    public function showAction(Request $request, OrderCarte $orderCarte)
    {
        $form = $this->createPaymentMethodForm($orderCarte, ProductEntityInterface::PRODUCT_TYPE_CARTE);
        
        $form->add('orderCarte', OrderCarteType::class, [
            'user'  => $this->getUser(),
            'constraints'  => new \Symfony\Component\Validator\Constraints\Valid(),
            'data'  => $orderCarte
        ]);
        
        $form->handleRequest($request);
        
        if( $form->isSubmitted() && $form->isValid() )
        {
            $ppc = $this->get('payment.plugin_controller');
            $ppc->createPaymentInstruction($instruction = $form->getData());

            $orderCarte->setPaymentInstruction($instruction);
            
            $this->getDoctrineUtil()->persist($orderCarte);
            $this->getDoctrineUtil()->flush();

            return $this->redirectToRoute('carte_order_payment_create', [
                'order' => $orderCarte->getId(),
            ]);
        }

        return $this->render(self::BASE_VIEW_FOLDER . 'show.html.twig',[
            'orderCarte' => $orderCarte,
            'form'  => $form->createView(),
        ]);
    }
    
    /**
     * @ParamConverter("order", class="AppBundle\Entity\Payment\OrderCarte", options={"mapping": {"order" = "id"}})
     * @param OrderCarte $order
     * @return RedirectResponse
     */
    public function paymentCreateAction(OrderEntityInterface $order)
    {
        
        $payment    = $this->createPayment($order);
        $result     = $this->getResult($payment);
        $routeParam = [
            'productType'   => 'carte',
            'order'   => $order->getId()
        ];

        if ($result->getStatus() === Result::STATUS_PENDING) 
        {
            $ex = $result->getPluginException();

            if ($ex instanceof ActionRequiredException) {
                $action = $ex->getAction();

                if ($action instanceof VisitUrl) {
                    return $this->redirect($action->getUrl());
                }
            }
        }
        
        if ($result->getStatus() === Result::STATUS_SUCCESS) 
        {
            return $this->redirectToRoute(PaymentController::COMPLETE_ROUTE, $routeParam);
        }
        
        $this->addFlash('danger', 'flash.payment.unknow_error');
        
        return $this->redirectToRoute(PaymentController::FAIL_ROUTE, $routeParam);
        
        #throw $result->getPluginException();

        // In a real-world application you wouldn't throw the exception. You would,
        // for example, redirect to the showAction with a flash message informing
        // the user that the payment was not successful.
    }
}