<?php

namespace AppBundle\Exception;

/**
 * Description of ExceptionTrait
 *
 * @author Hubsine <contact@hubsine.com>
 */
trait ExceptionTrait
{
    public function arrayToString(array $array)
    {
        return implode('or ', $array);
    }
}
