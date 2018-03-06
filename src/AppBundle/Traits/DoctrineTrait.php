<?php

namespace AppBundle\Traits;

use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;

/**
 * Doctrine trait : Timestampable et Softdeleteable
 *
 * @author Hubsine <contact@hubsine.com>
 */
trait DoctrineTrait 
{
    use TimestampableEntity, SoftDeleteableEntity;
}
