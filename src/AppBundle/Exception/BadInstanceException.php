<?php

namespace AppBundle\Exception;

use AppBundle\Exception\ExceptionTrait;

/**
 * Description of BadInstanceException
 *
 * @author Hubsine <contact@hubsine.com>
 */
class BadInstanceException  extends \Exception
{
    use ExceptionTrait;
    
    const DEFAULT_MESSAGE = 'Bad unexpected instance "%s". Extected instance is "%s".';
    
    public function __construct($instance, $expectedInstance, string $message = "", int $code = 0, \Throwable $previous = null) 
    {
        if( empty($message) )
        {
            $message    = sprintf(self::DEFAULT_MESSAGE, $instance, $this->arrayToString($expectedInstance) );
        }
        
        parent::__construct($message, $code, $previous);
    }
}
