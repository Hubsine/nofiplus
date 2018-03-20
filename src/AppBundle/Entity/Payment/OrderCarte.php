<?php

namespace AppBundle\Entity\Payment;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use AppBundle\Entity\EntityInterface;
use AppBundle\Entity\AdminEntityInterface;
use AppBundle\Entity\Payment\OrderEntityInterface;
use AppBundle\Entity\ProductEntityInterface;
use AppBundle\Traits\DoctrineTrait;
use AppBundle\Traits\EntityRoutePrefixTrait;
use AppBundle\Entity\Payment\OrderTrait;
use AppBundle\Entity\Admin\Category\Carte;
use AppBundle\Entity\User\Abonne\Abonne;

/**
 * CarteOrder
 *
 * @ORM\Table(name="np_order_carte")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Payment\OrderCarteRepository")
 * 
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 * 
 * @UniqueEntity(fields={"user", "carte", "createdAt"}, message="assert.unique_entity.carte_order")
 */
class OrderCarte implements EntityInterface, OrderEntityInterface, AdminEntityInterface
{
    const ROUTE_PREFIX  = 'carte_order';
    
    use DoctrineTrait;
    use EntityRoutePrefixTrait;
    use OrderTrait;
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Carte
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Admin\Category\Carte")
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Assert\NotBlank(message="assert.not_blank", groups={"new"})
     * @Assert\Type(type="\AppBundle\Entity\Admin\Category\Carte", message="assert.type", groups={"new"})
     */
    private $carte;
    
    /**
     * @var Abonne
     * 
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User\Abonne\Abonne", inversedBy="orderCartes")
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Assert\NotBlank(message="assert.not_blank", groups={"new"})
     * @Assert\Type(type="\AppBundle\Entity\User\Abonne\Abonne", message="assert.type", groups={"new"})
     * @Assert\Valid()
     */
    private $user;
    
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
     * Set carte
     *
     * @param \AppBundle\Entity\Admin\Category\Carte $carte
     *
     * @return CarteOrder
     */
    public function setCarte(\AppBundle\Entity\Admin\Category\Carte $carte)
    {
        $this->carte = $carte;

        return $this;
    }

    /**
     * Get carte
     *
     * @return \AppBundle\Entity\Admin\Category\Carte
     */
    public function getCarte()
    {
        return $this->carte;
    }
    
    /**
     * Set user
     *
     * @param Abonne $user
     *
     * @return CarteOrder
     */
    public function setUser(Abonne $user)
    {
        $this->user = $user;
        
        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\Payment\Abonne
     */
    public function getUser()
    {
        return $this->user;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getProduct() : ProductEntityInterface
    {
        return $this->carte;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setProduct(ProductEntityInterface $product)
    {
        $this->carte    = $product;
        
        return $this;
    }
}
