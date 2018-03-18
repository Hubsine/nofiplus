<?php

namespace AppBundle\Controller\Payment;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use JMS\Payment\CoreBundle\Form\ChoosePaymentMethodType;
use AppBundle\Controller\Payment\AbstractPaymentController;
use AppBundle\Entity\Admin\Category\Carte;
use AppBundle\Entity\Payment\CarteOrder;
use AppBundle\Entity\User\Abonne\Abonne;

/**
 * @author Hubsine <contact@hubsine.com>
 */
class CarteOrderController extends AbstractPaymentController
{
    const BASE_VIEW_FOLDER   = '@Front/Payment/CarteOrder/';
    
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
        
        $pendingCarteOrder = $this->getDoctrineUtil()->getRepository(CarteOrder::class)->findOneBy([
            'user'  => $user->getId(),
            'carte' => $carte->getId(), 
            'paymentInstruction'    => null
        ]);
        
        $carteOrder = ( ! $pendingCarteOrder instanceof CarteOrder ) ? new CarteOrder() : $pendingCarteOrder;
        
        $carteOrder->setAmount($carte->getAmount());
        $carteOrder->setCarte($carte);
        $carteOrder->setUser($this->getUser());
        
        ( is_integer( $carteOrder->getId() ) ) ? $this->getDoctrineUtil()->flush() : $this->getDoctrineUtil()->persist($carteOrder);
        
        return $this->redirectToRoute($this->getCompleteRoute(CarteOrder::class, 'show'), [
            'order' => $carteOrder->getId()
        ]);
    }
    
    /**
     * @ParamConverter("carteOrder", options={"mapping": {"order" = "id"}})
     * 
     * @param Request $request
     * @param CarteOrder $carteOrder
     * @return Response
     */
    public function showAction(Request $request, CarteOrder $carteOrder)
    {
        
        $form = $this->createForm(ChoosePaymentMethodType::class, null, [
            'amount'   => $carteOrder->getAmount(),
            'currency' => 'EUR',
        ]);

        return $this->render(self::BASE_VIEW_FOLDER . 'show.html.twig',[
            'carteOrder' => $carteOrder,
            'form'  => $form->createView(),
        ]);
    }
}