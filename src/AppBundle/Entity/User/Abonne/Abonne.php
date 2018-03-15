<?php

namespace AppBundle\Entity\User\Abonne;

use AppBundle\Entity\User\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection as DoctrineArrayCollectionInterface;
use Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber as AssertPhoneNumber;
use AppBundle\Traits\EntityRoutePrefixTrait;
use AppBundle\Entity\AdminEntityInterface;
use AppBundle\Entity\User\UserTrait;

/**
 * 
 * User class entity
 * 
 * @ORM\Table(name="np_user_abonne")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\User\Abonne\AbonneRepository")
 * 
 * @author Hubsine <contact@hubsine.com>
 */
class Abonne extends BaseUser implements AdminEntityInterface
{
    CONST ROUTE_PREFIX = 'user_abonne';
    
    use UserTrait;
    use EntityRoutePrefixTrait;
    
    public function __construct()
    {
        parent::__construct();
    }
}
