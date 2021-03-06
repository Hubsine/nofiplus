<?php

namespace AppBundle\Entity\User\Abonne;

use AppBundle\Entity\User\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use AppBundle\Traits\EntityRoutePrefixTrait;
use AppBundle\Entity\AdminEntityInterface;
use AppBundle\Entity\User\UserTrait;
use AppBundle\Entity\Payment\OrderCarte;

/**
 * 
 * User class entity
 * 
 * @ORM\Table(name="np_user_abonne")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\User\Abonne\AbonneRepository")
 * 
 * @author Hubsine <contact@hubsine.com>
 */
class Abonne extends BaseUser implements AdminEntityInterface
{
    CONST ROUTE_PREFIX = 'user_abonne';
    
    use UserTrait;
    use EntityRoutePrefixTrait;

    /**
     * @var ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Payment\OrderCarte", mappedBy="user", cascade={"all"})
     * 
     * @Assert\Type(type="\Doctrine\Common\Collections\Collection", message="assert.type")
     */
    private $orderCartes;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\User\Abonne\Carte", mappedBy="user", cascade={"all"})
     * 
     * @Assert\Type(type="\Doctrine\Common\Collections\Collection", message="assert.type")
     */
    private $cartes;

    public function __construct()
    {
        parent::__construct();
        
        $this->orderCartes  = new ArrayCollection();
        $this->cartes       = new ArrayCollection();
        
        $this->setEnabledByAdmin(true);
    }
    
    public function isAdmin()
    {
        return false;
    }
    
    public function isPartner()
    {
        return false;
    }
    
    public function isAbonne()
    {
        return true;
    }

    /**
     * Add orderCarte
     *
     * @param \AppBundle\Entity\User\Abonne\OrderCarte $orderCarte
     *
     * @return Abonne
     */
    public function addOrderCarte(\AppBundle\Entity\Payment\OrderCarte $orderCarte)
    {
        $this->orderCartes[] = $orderCarte;

        return $this;
    }

    /**
     * Remove orderCarte
     *
     * @param AppBundle\Entity\Payment\OrderCarte $orderCarte
     */
    public function removeOrderCarte(\AppBundle\Entity\Payment\OrderCarte $orderCarte)
    {
        $this->orderCartes->removeElement($orderCarte);
    }

    /**
     * Get orderCartes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrderCartes()
    {
        return $this->orderCartes;
    }

    /**
     * Add carte
     *
     * @param \AppBundle\Entity\User\Abonne\Carte $carte
     *
     * @return Abonne
     */
    public function addCarte(\AppBundle\Entity\User\Abonne\Carte $carte)
    {
        $this->cartes[] = $carte;
        
        $carte->setUser($this);

        return $this;
    }

    /**
     * Remove carte
     *
     * @param \AppBundle\Entity\User\Abonne\Carte $carte
     */
    public function removeCarte(\AppBundle\Entity\User\Abonne\Carte $carte)
    {
        $this->cartes->removeElement($carte);
    }

    /**
     * Get cartes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCartes()
    {
        return $this->cartes;
    }
}
