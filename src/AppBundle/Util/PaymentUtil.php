<?php

namespace AppBundle\Util;

use JMS\Payment\CoreBundle\Model\PaymentInterface;
use AppBundle\Exception\UnexpectedValueException;

/**
 * Description of PaymentUtil
 *
 * @author Hubsine <contact@hubsine.com>
 */
class PaymentUtil 
{
    public static $avaibleStateCode = [
        PaymentInterface::STATE_APPROVED    => 'approved',
        PaymentInterface::STATE_APPROVING   => 'approving',
        PaymentInterface::STATE_CANCELED    => 'canceled',
        PaymentInterface::STATE_EXPIRED     => 'expired',
        PaymentInterface::STATE_FAILED      => 'failed',
        PaymentInterface::STATE_NEW         => 'new',
        PaymentInterface::STATE_DEPOSITING  => 'depositing',
        PaymentInterface::STATE_DEPOSITED   => 'deposited'
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
