<?php

namespace AppBundle\Controller\Payment;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use JMS\Payment\CoreBundle\Form\ChoosePaymentMethodType;
use AppBundle\Controller\Payment\AbstractPaymentController;
use AppBundle\Entity\Admin\Category\Carte;
use AppBundle\Entity\Payment\OrderCarte;
use AppBundle\Entity\User\Abonne\Abonne;

/**
 * @author Hubsine <contact@hubsine.com>
 */
class OrderCarteController extends AbstractPaymentController
{
    const BASE_VIEW_FOLDER   = '@Front/Payment/OrderCarte/';
    
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
        
        $carteOrder = ( ! $pendingOrderCarte instanceof OrderCarte ) ? new OrderCarte() : $pendingOrderCarte;
        
        $carteOrder->setAmount($carte->getAmount());
        $carteOrder->setCarte($carte);
        $carteOrder->setUser($this->getUser());
        
        ( is_integer( $carteOrder->getId() ) ) ? $this->getDoctrineUtil()->flush() : $this->getDoctrineUtil()->persist($carteOrder);
        
        return $this->redirectToRoute($this->getCompleteRoute(OrderCarte::class, 'show'), [
            'order' => $carteOrder->getId()
        ]);
    }
    
    /**
     * @ParamConverter("orderCarte", options={"mapping": {"order" = "id"}})
     * 
     * @param Request $request
     * @param OrderCarte $orderCarte
     * @return Response
     */
    public function showAction(OrderCarte $orderCarte)
    {
        
        $form = $this->createForm(ChoosePaymentMethodType::class, null, [
            'amount'   => $orderCarte->getAmount(),
            'currency' => 'EUR',
        ]);

        return $this->render(self::BASE_VIEW_FOLDER . 'show.html.twig',[
            'orderCarte' => $orderCarte,
            'form'  => $form->createView(),
        ]);
    }
}