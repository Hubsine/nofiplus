<?php

namespace AppBundle\Exception;

use AppBundle\Exception\ExceptionTrait;

/**
 * Description of InvalidTypeException
 *
 * @author Hubsine <contact@hubsine.com>
 */
class InvalidTypeException  extends \Exception
{
    use ExceptionTrait;
    
    const DEFAULT_MESSAGE = 'Invalid type "%s". Expected type is "%s".'; 
    
    /**
     * 
     * @param string $badType
     * @param string $expectedType
     * @param string $message
     * @param int $code
     * @param \Throwable $previous
     */
    public function __construct($badType, $expectedType, string $message = "", int $code = 0, \Throwable $previous = null) 
    {
        if( empty($message) )
        {
            $message    = sprintf( self::DEFAULT_MESSAGE, $badType, $expectedType );
        }
        
        parent::__construct($message, $code, $previous);
    }
}
