<?php

namespace AppBundle\Entity\User;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
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
 *  "admin"     = "AppBundle\Entity\User\Admin",
 *  "abonne"    = "AppBundle\Entity\User\Abonne\Abonne", 
 *  "partner"   = "AppBundle\Entity\User\Partner\Partner"})
 * 
 * @UniqueEntity("emailCanonical", repositoryMethod="findByUniqueCriteria", errorPath="email", message="fos_user.email.already_used")
 * @UniqueEntity("usernameCanonical", repositoryMethod="findByUniqueCriteria", errorPath="username", message="fos_user.username.already_used")
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
    protected $enabledByAdmin;

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
    public function getEnabledByAdmin() 
    {
        return $this->enabledByAdmin;
    }

    /**
     * Set enabledByAdmin
     * 
     * @param boolean $enabledByAdmin
     */
    public function setEnabledByAdmin($enabledByAdmin) 
    {
        $this->enabledByAdmin = $enabledByAdmin;
    }

    /**
     * Check if user account is enabled par admin 
     * 
     * @return boolean
     */
    public function isEnabledByAdmin()
    {
        return $this->enabledByAdmin !== false && $this->enabledByAdmin !== true ? false : $this->enabledByAdmin;
    }
}
