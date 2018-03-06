<?php

namespace AppBundle\Entity\Admin\Category;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Admin\Category\CategoryTrait;
use AppBundle\Entity\AdminEntityInterface;

/**
 * Carte
 *
 * @ORM\Table(name="admin_category_carte")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Admin\Category\CarteRepository")
 */
class Carte implements AdminEntityInterface
{
    CONST ROUTE_PREFIX = 'category_carte';
            
    use CategoryTrait;
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var integer
     * 
     * @ORM\Column(type="integer", name="price")
     * 
     * @Assert\NotBlank(message="assert.not_blank")
     * @Assert\Type(type="integer", message="assert.type")
     */
    private $price;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="about", type="string")
     * 
     * @Assert\NotBlank(message="assert.not_blank")
     * @Assert\Type(type="string", message="assert.type")
     */
    private $about;

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

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Carte
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set about
     *
     * @param string $about
     *
     * @return Carte
     */
    public function setAbout($about)
    {
        $this->about = $about;

        return $this;
    }

    /**
     * Get about
     *
     * @return string
     */
    public function getAbout()
    {
        return $this->about;
    }
}
