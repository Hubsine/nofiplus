<?php

namespace AppBundle\Exception;

use AppBundle\Exception\ExceptionTrait;

/**
 * Description of UndefinedFunctionException
 *
 * @author Hubsine <contact@hubsine.com>
 */
class UndefinedFunctionException  extends \Exception
{
    use ExceptionTrait;
    
    const DEFAULT_MESSAGE = 'Undefined function "%s" on class "%s".';
    
    /**
     * 
     * @param string $functionName
     * @param string $className
     * @param string $message
     * @param int $code
     * @param \Throwable $previous
     */
    public function __construct($functionName, $className, string $message = "", int $code = 0, \Throwable $previous = null) 
    {
        if( empty($message) )
        {
            $message    = sprintf( self::DEFAULT_MESSAGE, $functionName, $className );
        }
        
        parent::__construct($message, $code, $previous);
    }
}
