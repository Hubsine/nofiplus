<?php

namespace AppBundle\Entity\Admin\Category;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Admin\Category\CategoryTrait;
use AppBundle\Traits\EntityRoutePrefixTrait;
use AppBundle\Entity\AdminEntityInterface;
use AppBundle\Entity\ProductEntityInterface;

/**
 * Carte
 *
 * @ORM\Table(name="np_category_carte")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Admin\Category\CarteRepository")
 */
class Carte implements AdminEntityInterface, ProductEntityInterface
{
    CONST ROUTE_PREFIX = 'category_carte';
            
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
     * @var float
     *
     * @ORM\Column(name="amount", type="decimal", precision=10, scale=2)
     * 
     * @Assert\NotBlank(message="assert.not_blank")
     * @Assert\Type(type="float", message="assert.type")
     */
    private $amount;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set amount
     *
     * @param string $amount
     *
     * @return CarteOrder
     */
    public function setAmount($amount)
    {
        $this->amount = (float) $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }
}
