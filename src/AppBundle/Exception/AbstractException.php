<?php

namespace AppBundle\Exception;

/**
 * Description of AbstractException
 *
 * @author Hubsine <contact@hubsine.com>
 */
abstract class AbstractException extends \Exception
{
    public function arrayToString(array $array)
    {
        return implode(', ', $array);
    }
}
