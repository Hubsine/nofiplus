<?php

namespace AppBundle\Exception;

/**
 * Description of ExceptionTrait
 *
 * @author Hubsine <contact@hubsine.com>
 */
trait ExceptionTrait
{
    /**
     * Array to string 
     * 
     * @param mixed $value
     * @return string
     */
    public function arrayToString($value)
    {
        return is_array( $value ) ? implode('or ', $value) : $value;
    }
}
