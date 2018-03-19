<?php

namespace AppBundle\Exception;

use AppBundle\Exception\ExceptionTrait;

/**
 * Description of UndefinedConstantException
 *
 * @author Hubsine <contact@hubsine.com>
 */
class UndefinedConstantException  extends \Exception
{
    use ExceptionTrait;
    
    const DEFAULT_MESSAGE = 'Undefined constant exception "%s"';
    
    /**
     * 
     * @param string $constantName 
     * @param string $message
     * @param int $code
     * @param \Throwable $previous
     */
    public function __construct($constantName, string $message = "", int $code = 0, \Throwable $previous = null) 
    {
        if( empty($message) )
        {
            $message    = sprintf( self::DEFAULT_MESSAGE, $constantName );
        }
        
        parent::__construct($message, $code, $previous);
    }
}
