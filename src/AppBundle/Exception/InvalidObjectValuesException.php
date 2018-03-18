<?php

namespace AppBundle\Exception;

use AppBundle\Exception\ExceptionTrait;

/**
 * Description of InvalidObjectValuesException
 *
 * @author Hubsine <contact@hubsine.com>
 */
class InvalidObjectValuesException  extends \Exception
{
    use ExceptionTrait;
    
    const DEFAULT_MESSAGE = 'Invalid object values for class %s.';
    
    public function __construct($objectClass, string $message = "", int $code = 0, \Throwable $previous = null) 
    {
        if( empty($message) )
        {
            $message    = sprintf(self::DEFAULT_MESSAGE, $objectClass);
        }
        
        parent::__construct($message, $code, $previous);
    }
}
