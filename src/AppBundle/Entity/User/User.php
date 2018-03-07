<?php

namespace AppBundle\Entity\User;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Traits\DoctrineTrait;

/**
 * User class entity
 * 
 * @ORM\Table(name="np_user")
 * @ORM\Entity(repositoryClass="\AppBundle\Repository\User\UserRepository")
 * 
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({
 *  "admin" = "AppBundle\Entity\User\Admin",
 *  "abonne" = "AppBundle\Entity\User\Abonne\Abonne", 
 *  "partner" = "AppBundle\Entity\User\Partner\Partner"})
 * 
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 * 
 * @author Hubsine <contact@hubsine.com>
 */
abstract class User extends BaseUser 
{
    const PARTNER_TYPE  = 'partner';
    const ABONNE_TYPE   = 'abonne';
    const ADMIN_TYPE    = 'admin';
    
    use DoctrineTrait;
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var string
     * 
     * @ORM\Column(unique=true, name="slug")
     * @Gedmo\Slug(fields={"username", "id"})
     * 
     */
    protected $slug;

    /**
     * @var boolean
     * 
     * @ORM\Column(name="enabled_by_admin", type="boolean", nullable=true)
     */
    protected $enbaledByAdmin;

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return User
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
    
    /**
     * get enabledByAdmin
     * 
     * @return boolean
     */
    public function getEnbaledByAdmin() 
    {
        return $this->enbaledByAdmin;
    }

    /**
     * Set enabledByAdmin
     * 
     * @param boolean $enbaledByAdmin
     */
    public function setEnbaledByAdmin($enbaledByAdmin) 
    {
        $this->enbaledByAdmin = $enbaledByAdmin;
    }


}
