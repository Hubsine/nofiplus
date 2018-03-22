<?php

namespace AppBundle\Entity\Admin\Category;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Admin\Category\CategoryTrait;
use AppBundle\Traits\EntityRoutePrefixTrait;
use AppBundle\Entity\AdminEntityInterface;

/**
 * OffreDomain
 *
 * @ORM\Table(name="np_category_offre_domain")
 * @ORM\Entity(repositoryClass="\AppBundle\Repository\Admin\Category\OffreDomainRepository")
 */
class OffreDomain implements AdminEntityInterface
{
    CONST ROUTE_PREFIX = 'category_offre_domain';
            
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
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\User\Partner\Offre", mappedBy="offreDomain", cascade={"all"})
     * 
     * @Assert\Type(type="\Doctrine\Common\Collections\Collection", message="assert.type")
     */
    private $offres;

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
     * Constructor
     */
    public function __construct()
    {
        $this->offres = new ArrayCollection();
}

    /**
     * Add offre
     *
     * @param \AppBundle\Entity\User\Partner\Offre $offre
     *
     * @return OffreDomain
     */
    public function addOffre(\AppBundle\Entity\User\Partner\Offre $offre)
    {
        $this->offres[] = $offre;

        return $this;
    }

    /**
     * Remove offre
     *
     * @param \AppBundle\Entity\User\Partner\Offre $offre
     */
    public function removeOffre(\AppBundle\Entity\User\Partner\Offre $offre)
    {
        $this->offres->removeElement($offre);
    }

    /**
     * Get offres
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOffres()
    {
        return $this->offres;
    }
}
