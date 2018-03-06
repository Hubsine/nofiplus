<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Traits;

/**
 *
 * @author Hubsine <contact@hubsine.com>
 */
trait EntityRoutePrefixTrait 
{
    /**
     * {@inhertdoc}
     */
    public static function getRoutePrefix(): string
    {
        return self::ROUTE_PREFIX;
    }
}
