<?php

namespace AppBundle\Entity\Media;

/**
 * Description of MediaInterface
 *
 * @author Hubsine <contact@hubsine.com>
 */
interface MediaInterface 
{
    /**
     * @return string a file path
     */
    public function getPath(): string;
}
