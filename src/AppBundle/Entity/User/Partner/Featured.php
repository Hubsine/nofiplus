<?php

namespace AppBundle\Entity\User\Partner;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Traits\DoctrineTrait;

/**
 * Featured
 *
 * @ORM\Table(name="np_user_partner_featured")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\User\Partner\FeaturedRepository")
 * 
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 */
class Featured
{
    use DoctrineTrait;
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\OneToOne(targetEntity="\AppBundle\Entity\User\Partner\Offre", inversedBy="featured")
     * 
     * @Assert\Type(type="\AppBundle\Entity\User\Partner\Offre")
     */
    private $offre;


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
     * Set offre
     *
     * @param \AppBundle\Entity\User\Partner\Offre $offre
     *
     * @return Featured
     */
    public function setOffre(\AppBundle\Entity\User\Partner\Offre $offre = null)
    {
        $this->offre = $offre;

        return $this;
    }

    /**
     * Get offre
     *
     * @return \AppBundle\Entity\User\Partner\Offre
     */
    public function getOffre()
    {
        return $this->offre;
    }
}
