<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\EntityInterface;
use AppBundle\Entity\AdminEntityInterface;
use AppBundle\Traits\DoctrineTrait;
use AppBundle\Traits\EntityRoutePrefixTrait;

/**
 * Contact
 *
 * @ORM\Table(name="np_contact")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ContactRepository")
 * 
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 */
class Contact implements EntityInterface, AdminEntityInterface
{
    const ROUTE_PREFIX  = 'contact';
    
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
     * @ORM\Column(name="fromName", type="string", length=255)
     * 
     * @Assert\NotBlank(message="assert.not_blank")
     * @Assert\Type(type="string", message="assert.type")
     */
    private $fromName;

    /**
     * @var string
     *
     * @ORM\Column(name="fromEmail", type="string", length=255)
     * 
     * @Assert\NotBlank(message="assert.not_blank")
     * @Assert\Email(
     *  message="assert.email",
     *  checkMX = true,
     *  checkHost = true
     * )
     */
    private $fromEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=255)
     * 
     * @Assert\NotBlank(message="assert.not_blank")
     * @Assert\Type(type="string", message="assert.type")
     */
    private $subject;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text")
     * 
     * @Assert\NotBlank(message="assert.not_blank")
     * @Assert\Type(type="string", message="assert.type")
     */
    private $message;


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
     * Set fromName
     *
     * @param string $fromName
     *
     * @return Contact
     */
    public function setFromName($fromName)
    {
        $this->fromName = $fromName;

        return $this;
    }

    /**
     * Get fromName
     *
     * @return string
     */
    public function getFromName()
    {
        return $this->fromName;
    }

    /**
     * Set fromEmail
     *
     * @param string $fromEmail
     *
     * @return Contact
     */
    public function setFromEmail($fromEmail)
    {
        $this->fromEmail = $fromEmail;

        return $this;
    }

    /**
     * Get fromEmail
     *
     * @return string
     */
    public function getFromEmail()
    {
        return $this->fromEmail;
    }

    /**
     * Set subject
     *
     * @param string $subject
     *
     * @return Contact
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return Contact
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
}

