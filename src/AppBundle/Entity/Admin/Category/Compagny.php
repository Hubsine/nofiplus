<?php

namespace AppBundle\Entity\Admin\Category;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Admin\Category\CategoryTrait;
use AppBundle\Entity\AdminEntityInterface;

/**
 * Compagny
 *
 * @ORM\Table(name="np_category_compagny")
 * @ORM\Entity(repositoryClass="\AppBundle\Repository\Admin\Category\CompagnyRepository")
 */
class Compagny implements AdminEntityInterface
{
    CONST ROUTE_PREFIX = 'category_compagny';
            
    use CategoryTrait;
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    public static function getRoutePrefix(): string
    {
        return self::ROUTE_PREFIX;
    }
    
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}

