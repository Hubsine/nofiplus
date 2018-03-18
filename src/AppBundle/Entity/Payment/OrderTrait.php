<?php

namespace AppBundle\Entity\Payment;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Payment\CoreBundle\Model\PaymentInstructionInterface;
use AppBundle\Entity\AddressTrait;

trait OrderTrait
{
    use AddressTrait;
    
    /**
     * @var \JMS\Payment\CoreBundle\Model\PaymentInstructionInterface
     *
     * @ORM\OneToOne(targetEntity="\JMS\Payment\CoreBundle\Entity\PaymentInstruction", cascade={"all"})
     * 
     * @Assert\Type(type="\JMS\Payment\CoreBundle\Model\PaymentInstructionInterface", message="assert.type")
     */
    private $paymentInstruction;

    /**
     * @var float
     *
     * @ORM\Column(name="amount", type="decimal", precision=10, scale=2)
     * 
     * @Assert\NotBlank(message="assert.not_blank", groups={"new"})
     * @Assert\Type(type="float", message="assert.type", groups={"new"})
     */
    private $amount;

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
     * @param PaymentInstructionInterface $paymentInstruction
     *
     * @return CarteOrder
     */
    public function setPaymentInstruction(PaymentInstructionInterface $paymentInstruction)
    {
        $this->paymentInstruction = $paymentInstruction;

        return $this;
    }

    /**
     * Get paymentInstruction
     *
     * @return PaymentInstructionInterface
     */
    public function getPaymentInstruction() : PaymentInstructionInterface
    {
        return $this->paymentInstruction;
    }
}
