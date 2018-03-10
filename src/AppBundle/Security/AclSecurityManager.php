<?php

namespace AppBundle\Security;

use Symfony\Component\Security\Acl\Dbal\MutableAclProvider;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilderInterface;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Symfony\Component\Security\Acl\Model\MutableAclInterface;
use Symfony\Component\Security\Acl\Model\DomainObjectInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\InvalidArgumentException;
use Symfony\Component\Security\Acl\Exception\InvalidDomainObjectException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use AppBundle\Entity\EntityInterface;
use Symfony\Component\Security\Core\Role\Role;
use FOS\UserBundle\Model\User;
use AppBundle\Entity\User\User as AppUser;

/**
 * Un simple servce pour gérer les Access Control Entry (ACE) 
 *
 * @author Hubsine <contact@hubsine.com>
 */
class AclSecurityManager 
{
    /** 
     * @var MutableAclProvider $aclProvider 
     */
    private $aclProvider;
    
    /** 
     * @var TokenStorage $tokenStorage 
     */
    private $tokenStorage;
    
    /**
     * @var AuthorizationCheckerInterface
     */
    private $authorizationChecker;


    /**
     * Constructor
     * 
     * @param MutableAclProvider $aclProvider
     * @param TokenStorage $tokenStorage
     */
    public function __construct(MutableAclProvider $aclProvider, TokenStorage $tokenStorage, AuthorizationCheckerInterface $authorizationChecker) 
    {
        $this->aclProvider  = $aclProvider;
        $this->tokenStorage = $tokenStorage;
        $this->authorizationChecker = $authorizationChecker;
    }
    
    /**
     * Create a acl from entity object
     * 
     * @param EntityInterface $object
     * @return MutableAclInterface 
     */
    public function createAcl(EntityInterface $object)
    {
        $objectIdentity = ObjectIdentity::fromDomainObject($object);
        $acl = $this->aclProvider->createAcl($objectIdentity);
        
        return $acl;
    }
    
    /**
     * Create security identity from a User 
     * 
     * @return UserSecurityIdentity
     */
    public function createSecurityIdentity(UserInterface $user = null)
    {
        if( null === $user || "" === $user )
        {
            $token = $this->tokenStorage->getToken();
            
            if( null === $token )
            {
                throw new InvalidArgumentException('A user must be provided for create security identity');
            }
            
            $user = $token->getUser();
        }
        
        if( null === $user->getId() || "" === $user->getId() || !is_integer($user->getId()) )
        {
            throw new InvalidDomainObjectException('A user must have a valid property id (persist in database)');
        }
        
        $securityIdentity = UserSecurityIdentity::fromAccount($user);
        
        return $securityIdentity;
    }
    
    /**
     * Insert Object ACE. Must be first.
     * 
     * @param EntityInterface $object
     * @param MaskBuilderInterface $mask
     */
    public function insertObjectAce(EntityInterface $object, MaskBuilderInterface $mask, UserInterface $user = null)
    {
        $acl                = $this->createAcl($object);
        $securityIdentity   = $this->createSecurityIdentity($user);
        
        $acl->insertObjectAce($securityIdentity, $mask->get());
        $this->aclProvider->updateAcl($acl);
    }
    
    /**
     * Update user security identity 
     * 
     * @param User $user
     * @param string $oldUsername
     */
    public function updateUserSecurityIdentity(User $user, $oldUsername)
    {
        if( $user->getUsername() !== $oldUsername )
        {
            $securityIdentity   = $this->createSecurityIdentity($user);
            $this->aclProvider->updateUserSecurityIdentity($securityIdentity, $oldUsername);
        }
    }
    
    /**
     * Get new MaskBuilder instance 
     * 
     * @param integer $mask
     * @return MaskBuilder
     */
    public function getMaskBuilder(int $mask = 0)
    {
        return new MaskBuilder($mask);
    }
}
