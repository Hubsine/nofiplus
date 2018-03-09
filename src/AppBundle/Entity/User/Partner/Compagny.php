<?php

namespace AppBundle\Entity\User\Partner;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use AppBundle\Traits\DoctrineTrait;
use AppBundle\Traits\EntityRoutePrefixTrait;
use AppBundle\Entity\AdminEntityInterface;

/**
 * Compagny
 *
 * @ORM\Table(name="np_user_partner_compagny")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\User\Partner\CompagnyRepository")
 * 
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 * 
 */
class Compagny implements AdminEntityInterface
{
    use DoctrineTrait;
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * 
     * @Assert\NotBlank(message="assert.not_blank")
     * @Assert\Type(type="string", message="assert.type")
     */
    private $name;

    /**
     * @var string
     * 
     * @ORM\OneToOne(targetEntity="\AppBundle\Entity\Address", cascade={"persist", "remove"})
     * 
     * @Assert\Type(type="\AppBundle\Entity\Address")
     * @Assert\Valid()
     */
    private $address;

    /**
     * @var \AppBundle\Entity\User\Partner\CompagnyLogo
     * 
     * @ORM\OneToOne(targetEntity="\AppBundle\Entity\User\Partner\CompagnyLogo", mappedBy="compagny", cascade={"persist", "remove"})
     * 
     * @Assert\Type(type="\AppBundle\Entity\User\Partner\CompagnyLogo")
     * @Assert\Valid()
     */
    private $logo;

    /**
     * @var \AppBundle\Entity\User\Partner\Partner
     * 
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\User\Partner\Partner", inversedBy="compagnies")
     * 
     * @Assert\Type(type="\AppBundle\Entity\User\Partner\Partner")
     * @Assert\Valid()
     */
    private $partner;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\User\Partner\Offre", mappedBy="compagny", cascade={"persist", "remove"})
     * 
     * @Assert\Type(type="\Doctrine\ORM\PersistentCollection", message="assert.type")
     * @Assert\Valid()
     */
    private $offres;

    /**
     * @var \AppBundle\Entity\Admin\Category\Compagny
     *
     * @ORM\OneToOne(targetEntity="\AppBundle\Entity\Admin\Category\Compagny")
     * 
     * @Assert\Type(type="\AppBundle\Entity\Admin\Category\Compagny", message="assert.type")
     */
    private $category;

   /**
     * @var string
     * 
     * @ORM\Column(unique=true, name="slug")
     * @Gedmo\Slug(fields={"name", "id"})
     */
    private $slug;

}

