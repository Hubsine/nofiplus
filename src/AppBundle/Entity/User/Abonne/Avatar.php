<?php

namespace AppBundle\Entity\User\Abonne;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use AppBundle\Traits\DoctrineTrait;
use AppBundle\Entity\Media\ImageTrait;
use AppBundle\Traits\EntityRoutePrefixTrait;
use AppBundle\Entity\Media\MediaInterface;

/**
 * Description of Avatar
 *
 * ORM\Table(name="np_user_abonne_avatar")
 * ORM\Entity(repositoryClass="\AppBundle\Repository\User\Abonne\AvatarRepository")
 * 
 * Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 * 
 * @author Hubsine <contact@hubsine.com>
 */
class Avatar implements MediaInterface
{
    const FOLDER = 'uploads/users/avatars';
    const ROUTE_PREFIX = 'profile_avatar';

    use DoctrineTrait;
    use ImageTrait;
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
     * @var User
     * 
     * @ORM\OneToOne(targetEntity="\AppBundle\Entity\User\Abonne\Abonne", inversedBy="avatar")
     * 
     */
    private $user;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    
    public static function getRoutePrefix(): string
    {
        return self::ROUTE_PREFIX;
    }

    /**
     * Get upload folder
     * 
     * @return string
     */
    public function getPath(): string
    {
        return self::FOLDER;
    }
    
    /**
     * Set path
     * 
     * @param string $path
     * @return $this
     */
    public function setPath($path)
    {
        $this->path = $path;
        
        return $this;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User\User $user
     *
     * @return ProfileImage
     */
    public function setUser(\AppBundle\Entity\User\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
