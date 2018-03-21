<?php

namespace AppBundle\Entity\User\Abonne;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use AppBundle\Traits\DoctrineTrait;
use AppBundle\Entity\DateTrait;
use AppBundle\Entity\EntityInterface;
use AppBundle\Entity\User\Abonne\Abonne;
use AppBundle\Entity\Admin\Category\Carte as CatCarte;

/**
 * Carte
 *
 * @ORM\Table(name="np_user_abonne_carte")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\User\Abonne\CarteRepository")
 * 
 * @UniqueEntity(fields="number", message="assert.unique_entity.carte_number");
 * 
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 */
class Carte implements EntityInterface
{
    use DoctrineTrait;
    use DateTrait;
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Admin\Category\Carte
     *
     * @ORM\OneToOne(targetEntity="\AppBundle\Entity\Admin\Category\Carte")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @var int
     *
     * @ORM\Column(name="number", type="integer", unique=true)
     * 
     * @Assert\NotBlank(message="assert.not_blank")
     * @Assert\Length(
     *      min = 8,
     *      max = 8,
     *      minMessage = "assert.length.min",
     *      maxMessage = "assert.length.max"
     * )
     */
    private $number;

    /**
     * @var \AppBundle\Entity\User\Abonne\Abonne
     *
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\User\Abonne\Abonne", inversedBy="cartes")
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Assert\Type(type="\AppBundle\Entity\User\Abonne\Abonne", message="assert.type")
     */
    private $user;

    /**
     * @var \DateTime
     * 
     * @ORM\Column(name="start", type="datetime")
     * 
     * @Assert\NotBlank(message="assert.not_blank")
     * @Assert\Date(message="assert.date")
     * @Assert\EqualTo("today UTC", message="assert.date.equal_to")
     * @Assert\LessThan(propertyPath="end", message="assert.date.less_than")
     * @Assert\LessThan(value="-1 year", message="assert.date.less_than")
     */
    private $start;
    
    /**
     * @var \DateTime
     * 
     * @ORM\Column(name="end", type="datetime")
     * 
     * @Assert\NotBlank(message="assert.not_blank")
     * @Assert\Date(message="assert.date")
     * @Assert\GreaterThan(propertyPath="start", message="assert.date.greater_than")
     * @Assert\GreaterThan(value="+1 year", message="assert.date.greater_than")
     */
    private $end;
    
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
     * Set number
     *
     * @param integer $number
     *
     * @return Carte
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set category
     *
     * @param \AppBundle\Entity\Admin\Category\Carte $category
     *
     * @return Carte
     */
    public function setCategory(Carte $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Admin\Category\Carte
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User\Abonne\Abonne $user
     *
     * @return Carte
     */
    public function setUser(Abonne $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User\Abonne\Abonne
     */
    public function getUser()
    {
        return $this->user;
    }
}
