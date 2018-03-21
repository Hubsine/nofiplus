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
use AppBundle\Entity\Payment\OrderEntityInterface;
use AppBundle\Entity\Payment\OrderCarte;

/**
 * Carte
 *
 * @ORM\Table(name="np_user_abonne_carte")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\User\Abonne\CarteRepository")
 * 
 * @UniqueEntity(fields="number", message="assert.unique_entity.carte_number");
 * @UniqueEntity(fields={"user", "order"}, message="assert.unique_entity.user_carte_order");
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
     * @Assert\LessThan(value="+1 year", message="assert.date.less_than")
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
     * @Assert\GreaterThan(value="-1 year", message="assert.date.greater_than")
     */
    private $end;

    /**
     * @var \AppBundle\Entity\Payment\OrderCarte
     * 
     * @ORM\OneToOne(targetEntity="\AppBundle\Entity\Payment\OrderCarte", inversedBy="abonneCarte")
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Assert\NotBlank(message="assert.not_blank")
     * @Assert\Type(type="\AppBundle\Entity\Payment\OrderCarte")
     */
    private $order;

    public function __construct(OrderEntityInterface $order = null) 
    {
        $this->start =  new \DateTime('today');
        $this->end   = date_modify( new \DateTime('today'), '+1 year' );
        
        if( $order instanceof OrderEntityInterface)
        {
            $this->setOrder($order);
            $this->number = self::createNewNumber($order->getUser());
            $this->user   = $order->getUser();
            $this->category = $order->getCarte();
        }
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
    
    public static function createNewNumber(Abonne $abonne)
    {
        $userId = $abonne->getId();
        $number = mt_rand(10000000, 90000000); // Get un entier de longueur 8
        $sub = substr( $number, 0, 8 - strlen($userId) ); 

        return (int) $userId .= $sub;
    }

    /**
     * Set order
     *
     * @param \AppBundle\Entity\Payment\OrderCarte $order
     *
     * @return Carte
     */
    public function setOrder(\AppBundle\Entity\Payment\OrderCarte $order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return \AppBundle\Entity\Payment\OrderCarte
     */
    public function getOrder()
    {
        return $this->order;
    }
}
