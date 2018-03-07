<?php

namespace AppBundle\Exception;

use AppBundle\Exception\ExceptionTrait;

/**
 * Description of UnexpectedValueException
 *
 * @author Hubsine <contact@hubsine.com>
 */
class UnexpectedValueException  extends \Exception
{
    use ExceptionTrait;
    
    const DEFAULT_MESSAGE = 'Unexpected value "%s". Extected value is "%s".';
    
    public function __construct($value, $expectedValue, string $message = "", int $code = 0, \Throwable $previous = null) 
    {
        if( empty($message) )
        {
            $message    = sprintf(self::DEFAULT_MESSAGE, $value, is_array( $expectedValue ) ? $this->arrayToString($expectedValue) : $expectedValue );
        }
        
        parent::__construct($message, $code, $previous);
    }
}
