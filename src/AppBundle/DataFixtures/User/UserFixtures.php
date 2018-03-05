<?php

namespace AppBundle\DataFixtures\User;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use AppBundle\Entity\User\User;
use AppBundle\DataFixtures\DataBaseFixtures;

/**
 * Description of UserFixtures
 *
 * @author Hubsine <contact@hubsine.com>
 */
class UserFixtures extends DataBaseFixtures
{
    /** 
     * @var UserPasswordEncoderInterface $encoder 
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder) 
    {
        $this->encoder = $encoder;       
    }
    
    public function load(ObjectManager $manager)
    {
        
        ###
        # Admin
        ###
        $user = new User();
        
        $user->addRole(User::ROLE_SUPER_ADMIN);
        $user->setUsername('Super admin');
        $user->setPassword($this->encoder->encodePassword($user, 'password'));
        $user->setEmail('super_admin@nofiplus.com');
        $user->setEnabled(true);

        $manager->persist($user);
        $manager->flush();
            
        $mask = $this->createMaskBuilder();
        $mask->add('OWNER');
        $this->container->get('app.security.acl_manager')->insertObjectAce($user, $mask, $user);
            
        $this->addReference('super_admin', $user);
        
    }
}
