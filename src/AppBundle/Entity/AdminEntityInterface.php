<?php

namespace AppBundle\Entity;

use AppBundle\Entity\EntityInterface;

/**
 * Interface pour toutes les entitées
 *
 * @author Hubsine <contact@hubsine.com>
 */
interface AdminEntityInterface extends EntityInterface
{
    public static function getRoutePrefix() : string;
}
