<?php

namespace AppBundle\Entity\Payment;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\EntityInterface;
use AppBundle\Entity\AdminEntityInterface;
use AppBundle\Traits\DoctrineTrait;
use AppBundle\Traits\EntityRoutePrefixTrait;
use AppBundle\Entity\Admin\Category\Carte;
use AppBundle\Entity\User\Abonne\Abonne;

/**
 * CarteOrder
 *
 * @ORM\Table(name="np_carte_order")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Payment\CarteOrderRepository")
 * 
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 */
class CarteOrder implements EntityInterface, AdminEntityInterface
{
    const ROUTE_PREFIX  = 'carte_order';
    
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
     * @var \JMS\Payment\CoreBundle\Entity\PaymentInstruction
     *
     * @ORM\OneToOne(targetEntity="\JMS\Payment\CoreBundle\Entity\PaymentInstruction")
     * 
     * @Assert\NotBlank(message="assert.not_blank")
     * @Assert\Type(type="JMS\Payment\CoreBundle\Model\PaymentInstructionInterface", message="assert.type")
     */
    private $paymentInstruction;

    /**
     * @var float
     *
     * @ORM\Column(name="amount", type="decimal", precision=10, scale=5)
     * 
     * @Assert\NotBlank(message="assert.not_blank")
     * @Assert\Type(type="float", message="assert.type")
     */
    private $amount;

    /**
     * @var Carte
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Admin\Category\Carte")
     * 
     * @Assert\NotBlank(message="assert.not_blank")
     * @Assert\Type(type="Carte", message="assert.type")
     */
    private $carte;
    
    /**
     * @var Abonne
     * 
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User\Abonne\Abonne", inversedBy="orderCartes")
     * 
     * @Assert\NotBlank(message="assert.not_blank")
     * @Assert\Type(type="Abonne", message="assert.type")
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
     * @param \AppBundle\Entity\Payment\Carte $carte
     *
     * @return CarteOrder
     */
    public function setCarte(\AppBundle\Entity\Payment\Carte $carte)
    {
        $this->carte = $carte;

        return $this;
    }

    /**
     * Get carte
     *
     * @return \AppBundle\Entity\Payment\Carte
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
