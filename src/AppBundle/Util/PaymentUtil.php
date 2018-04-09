<?php

namespace AppBundle\Util;

use JMS\Payment\CoreBundle\Model\FinancialTransactionInterface;
use AppBundle\Exception\UnexpectedValueException;

/**
 * Description of PaymentUtil
 *
 * @author Hubsine <contact@hubsine.com>
 */
class PaymentUtil 
{
    public static $avaibleStateCode = [
        FinancialTransactionInterface::STATE_CANCELED   => 'canceled',
        FinancialTransactionInterface::STATE_FAILED     => 'failed',
        FinancialTransactionInterface::STATE_NEW        => 'new',   
        FinancialTransactionInterface::STATE_PENDING    => 'pending',
        FinancialTransactionInterface::STATE_SUCCESS    => 'success'
    ];
    
    public function getHumanPaymentState(int $stateCode)
    {  
        if( ! array_key_exists($stateCode, self::$avaibleStateCode) )
        {
            throw new UnexpectedValueException($stateCode, self::$avaibleStateCode);
        }
        
        return self::$avaibleStateCode[$stateCode];
    }
}
