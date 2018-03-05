<?php

namespace Tests\AppBundle\Security;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Exception\InvalidArgumentException;
use Symfony\Component\Security\Acl\Exception\InvalidDomainObjectException;
use Symfony\Component\Security\Acl\Model\SecurityIdentityInterface;
use AppBundle\Entity\User\User;

class AclSecurityManager extends WebTestCase
{
    
    public function testCreateSecurityIdentity()
    {
        $kernel = self::bootKernel();
        $container = $kernel->getContainer();
        $aclSecurityManager =  $container->get('app.security.acl_manager');
        
        ###
        # User is provided from parameter function
        ###
        $user = new User();
        $user->setUsername('foo');
        
        $reflectionPropertyId = new \ReflectionProperty($user, 'id');
        $reflectionPropertyId->setAccessible(true);
        $reflectionPropertyId->setValue($user, 1);
        
        $this->assertInstanceOf(SecurityIdentityInterface::class, $aclSecurityManager->createSecurityIdentity($user));
        
        ###
        # User is null
        ###
        $this->expectException(InvalidArgumentException::class);
        $aclSecurityManager->createSecurityIdentity();
        
    }
    
    public function testCreateSecurityIdentityWithoutUserId()
    {
        $kernel = self::bootKernel();
        $container = $kernel->getContainer();
        $aclSecurityManager =  $container->get('app.security.acl_manager');
        
        $user = new User();
        $user->setUsername('foo');
        
        ###
        # User must be have a ID
        ###
        $this->expectException(InvalidDomainObjectException::class);
        $aclSecurityManager->createSecurityIdentity($user);
        
    }
    
    public function insertObjectAce(EntityInterface $object, MaskBuilderInterface $mask)
    {
        $acl                = $this->createAcl($object);
        $securityIdentity   = $this->createSecurityIdentity();
        
        $acl->insertObjectAce($securityIdentity, $mask->get());
        $this->aclProvider->updateAcl($acl);
    }
}
