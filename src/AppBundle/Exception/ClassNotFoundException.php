<?php

namespace AppBundle\Exception;

use AppBundle\Exception\ExceptionTrait;
    
/**
 * Description of ClassNotFoundException
 *
 * @author Hubsine <contact@hubsine.com>
 */
class ClassNotFoundException extends \Exception
{
    use ExceptionTrait;
    
    const DEFAULT_MESSAGE = 'Class "%s" not found';
    
    public function __construct($className, string $message = "", int $code = 0, \Throwable $previous = null) 
    {
        if( empty($message) )
        {
            $message = sprintf(self::DEFAULT_MESSAGE, $className);
        }
        
        parent::__construct($message, $code, $previous);
    }
}
