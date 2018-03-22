<?php

namespace AppBundle\Twig\Extensions;

use Symfony\Component\Templating\EngineInterface;
use JMS\Payment\CoreBundle\Model\FinancialTransactionInterface;
use AppBundle\Exception\UnexpectedValueException;

/**
 * Description of PaymentExtension
 *
 * @author Hubsine <contact@hubsine.com>
 */
class PaymentExtension extends \Twig_Extension
{
    public static $avaibleStateCode = [
        FinancialTransactionInterface::STATE_CANCELED   => 'canceled',
        FinancialTransactionInterface::STATE_FAILED     => 'failed',
        FinancialTransactionInterface::STATE_NEW        => 'new',   
        FinancialTransactionInterface::STATE_PENDING    => 'pending',
        FinancialTransactionInterface::STATE_SUCCESS    => 'success'
    ];
    
    /**
     * @var TwigInterface $twig
     */
    private $twig;
    
    /**
     * Constructor
     * 
     * @param EngineInterface $twig
     */
    public function __construct(EngineInterface $twig) 
    {
        $this->twig         = $twig;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('getPaymentState',        array($this, 'getPaymentState')),
            new \Twig_SimpleFunction('renderPaymentState',     array($this, 'renderPaymentState'))
        );
    }
    
    public function getPaymentState(int $stateCode)
    {  
        if( ! array_key_exists($stateCode, self::$avaibleStateCode) )
        {
            throw new UnexpectedValueException($stateCode, self::$avaibleStateCode);
        }
        
        return self::$avaibleStateCode[$stateCode];
    }
    
    public function renderPaymentState(int $stateCode)
    {
        $stateString        = $this->getPaymentState($stateCode);
        $stateBadgeClass    = '';
        
        switch ( $stateCode )
        {
            case FinancialTransactionInterface::STATE_CANCELED:
                $stateBadgeClass .= 'secondery';
                break;
            
            case FinancialTransactionInterface::STATE_FAILED:
                $stateBadgeClass .= 'danger';
                break;
            
            case FinancialTransactionInterface::STATE_NEW:
                $stateBadgeClass .= 'primary';
                break;
            
            case FinancialTransactionInterface::STATE_PENDING:
                $stateBadgeClass .= 'warning';
                break;
            
            case FinancialTransactionInterface::STATE_SUCCESS:
                $stateBadgeClass .= 'success';
                break;
        }
        
        return $this->twig->render('@App/Snippet/payment_state.html.twig', [
            'stateBadgeClass'   => $stateBadgeClass,
            'stateString'       => $stateString
        ]);
    }
    
}
