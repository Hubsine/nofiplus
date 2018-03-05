<?php

namespace AppBundle\Exception;

/**
 * Description of ClassNotFoundException
 *
 * @author Hubsine <contact@hubsine.com>
 */
class ClassNotFoundException extends \Exception
{
    public function __construct($className, string $message = "", int $code = 0, \Throwable $previous = null) 
    {
        if( empty($message) )
        {
            $this->message = sprintf('Class "%s" not found', $className);
        }
        
        parent::__construct($message, $code, $previous);
    }
}
