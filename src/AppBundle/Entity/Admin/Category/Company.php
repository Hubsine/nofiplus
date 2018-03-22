<?php

namespace AppBundle\Entity\Admin\Category;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Admin\Category\CategoryTrait;
use AppBundle\Traits\EntityRoutePrefixTrait;
use AppBundle\Entity\AdminEntityInterface;

/**
 * Company
 *
 * @ORM\Table(name="np_category_company")
 * @ORM\Entity(repositoryClass="\AppBundle\Repository\Admin\Category\CompanyRepository")
 */
class Company implements AdminEntityInterface
{
    CONST ROUTE_PREFIX = 'category_company';
            
    use CategoryTrait;
    use EntityRoutePrefixTrait;
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
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

