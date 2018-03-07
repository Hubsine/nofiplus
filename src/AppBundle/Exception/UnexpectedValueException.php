<?php

namespace AppBundle\Exception;

use AppBundle\Exception\AbstractException;

/**
 * Description of UnexpectedValueException
 *
 * @author Hubsine <contact@hubsine.com>
 */
class UnexpectedValueException extends AbstractException
{
    const DEFAULT_MESSAGE = 'Unexpected value. Extected value is %s.';
    
    public function __construct($expectedValue, string $message = "", int $code = 0, \Throwable $previous = null) 
    {
        if( empty($message) )
        {
            $message    = sprintf(self::DEFAULT_MESSAGE, is_array( $expectedValue ) ? $this->arrayToString($expectedValue) : $expectedValue );
        }
        
        parent::__construct($message, $code, $previous);
    }
}
