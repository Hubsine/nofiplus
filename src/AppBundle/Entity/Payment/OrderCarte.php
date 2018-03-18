<?php

namespace AppBundle\Entity\Payment;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use AppBundle\Entity\EntityInterface;
use AppBundle\Entity\AdminEntityInterface;
use AppBundle\Entity\AddressTrait;
use AppBundle\Traits\DoctrineTrait;
use AppBundle\Traits\EntityRoutePrefixTrait;
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
class OrderCarte implements EntityInterface, AdminEntityInterface
{
    const ROUTE_PREFIX  = 'carte_order';
    
    use DoctrineTrait;
    use EntityRoutePrefixTrait;
    use AddressTrait;
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \JMS\Payment\CoreBundle\Entity\PaymentInstruction
     *
     * @ORM\OneToOne(targetEntity="\JMS\Payment\CoreBundle\Entity\PaymentInstruction", cascade={"all"})
     * 
     * @Assert\NotBlank(message="assert.not_blank")
     * @Assert\Type(type="JMS\Payment\CoreBundle\Model\PaymentInstructionInterface", message="assert.type")
     */
    private $paymentInstruction;

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
     * @var Carte
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Admin\Category\Carte")
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Assert\NotBlank(message="assert.not_blank")
     * @Assert\Type(type="Carte", message="assert.type")
     */
    private $carte;
    
    /**
     * @var Abonne
     * 
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User\Abonne\Abonne", inversedBy="orderCartes")
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Assert\NotBlank(message="assert.not_blank")
     * @Assert\Type(type="Abonne", message="assert.type")
     */
    private $user;
    
    /**
     * @var \AppBundle\Entity\Address
     * 
     * @ORM\OneToOne(targetEntity="\AppBundle\Entity\Address", cascade={"all"})
     * 
     * @Assert\NotBlank(message="assert.not_blank")
     * @Assert\Type(type="\AppBundle\Entity\Address")
     * @Assert\Valid()
     */
    private $address;
    
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

    /**
     * Set paymentInstruction
     *
     * @param \JMS\Payment\CoreBundle\Entity\PaymentInstruction $paymentInstruction
     *
     * @return CarteOrder
     */
    public function setPaymentInstruction(\JMS\Payment\CoreBundle\Entity\PaymentInstruction $paymentInstruction)
    {
        $this->paymentInstruction = $paymentInstruction;

        return $this;
    }

    /**
     * Get paymentInstruction
     *
     * @return \JMS\Payment\CoreBundle\Entity\PaymentInstruction
     */
    public function getPaymentInstruction()
    {
        return $this->paymentInstruction;
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
}
