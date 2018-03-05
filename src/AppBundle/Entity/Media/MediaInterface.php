<?php

namespace AppBundle\Entity\Media;

use AppBundle\Entity\AdminEntityInterface;

/**
 * Description of MediaInterface
 *
 * @author Hubsine <contact@hubsine.com>
 */
interface MediaInterface extends AdminEntityInterface
{
    /**
     * @return string a file path
     */
    public function getPath(): string;
}
