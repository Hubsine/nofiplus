<?php

namespace AppBundle\Twig\Extensions;

use Symfony\Component\Templating\EngineInterface;
use JMS\Payment\CoreBundle\Model\FinancialTransactionInterface;
use AppBundle\Util\PaymentUtil;

/**
 * Description of PaymentExtension
 *
 * @author Hubsine <contact@hubsine.com>
 */
class PaymentExtension extends \Twig_Extension
{
    /**
     * @var PaymentUtil
     */
    private $paymentUtil;
    
    /**
     * @var TwigInterface $twig
     */
    private $twig;
    
    public static $avaibleStateCode = [
        FinancialTransactionInterface::STATE_CANCELED   => 'canceled',
        FinancialTransactionInterface::STATE_FAILED     => 'failed',
        FinancialTransactionInterface::STATE_NEW        => 'new',   
        FinancialTransactionInterface::STATE_PENDING    => 'pending',
        FinancialTransactionInterface::STATE_SUCCESS    => 'success'
    ];
    
    /**
     * Constructor
     * 
     * @param EngineInterface $twig
     */
    public function __construct(EngineInterface $twig, PaymentUtil $paymentUtil) 
    {
        $this->twig         = $twig;
        $this->paymentUtil  = $paymentUtil;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('getHumanPaymentState',        array($this, 'getHumanPaymentState')),
            new \Twig_SimpleFunction('renderPaymentState',     array($this, 'renderPaymentState'))
        );
    }
    
    public function getHumanPaymentState(int $stateCode)
    {  
        return $this->paymentUtil->getHumanPaymentState($stateCode);
    }
    
    public function renderPaymentState(int $stateCode)
    {
        $stateString        = $this->getHumanPaymentState($stateCode);
        $stateBadgeClass    = 'success';
        
//        switch ( $stateCode )
//        {
//            case FinancialTransactionInterface::STATE_CANCELED:
//                $stateBadgeClass .= 'secondery';
//                break;
//            
//            case FinancialTransactionInterface::STATE_FAILED:
//                $stateBadgeClass .= 'danger';
//                break;
//            
//            case FinancialTransactionInterface::STATE_NEW:
//                $stateBadgeClass .= 'primary';
//                break;
//            
//            case FinancialTransactionInterface::STATE_PENDING:
//                $stateBadgeClass .= 'warning';
//                break;
//            
//            case FinancialTransactionInterface::STATE_SUCCESS:
//                $stateBadgeClass .= 'success';
//                break;
//        }
        
        return $this->twig->render('@App/Snippet/payment_state.html.twig', [
            'stateBadgeClass'   => $stateBadgeClass,
            'stateString'       => $stateString
        ]);
    }
    
}
