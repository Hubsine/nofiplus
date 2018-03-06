<?php

namespace AppBundle\DataFixtures\User;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use AppBundle\Entity\User\User;
use AppBundle\Entity\User\Admin;
use AppBundle\Entity\User\Abonne\Abonne;
use AppBundle\Entity\User\Partner\Partner;
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
        $user = new Admin();
        
        $user->addRole(User::ROLE_SUPER_ADMIN);
        $user->setUsername('Super admin');
        $user->setPassword($this->encoder->encodePassword($user, 'password'));
        $user->setEmail('super_admin@nofiplus.com');
        $user->setEnabled(true);

        $manager->persist($user);
        $manager->flush();
            
        $mask = $this->createMaskBuilder();
        $mask->add(MaskBuilder::MASK_OWNER);
        $this->container->get('app.security.acl_manager')->insertObjectAce($user, $mask, $user);
            
        $this->addReference('super_admin', $user);
        
        ###
        # Abonnes
        ###
        
        $abonnes = array();
        
        for($i = 0; $i <= 3; $i++)
        {
            $abonne = new Abonne();

            $abonne->addRole(User::ROLE_DEFAULT);
            $abonne->setUsername('Abonne' . $i);
            $abonne->setPassword($this->encoder->encodePassword($abonne, 'password'));
            $abonne->setEmail('abonne' . $i . '@nofiplus.com');
            $abonne->setGender($i < 2 ? 'male' : 'female');
            $abonne->setBirthday(new \DateTime('25-02-1983'));
            $abonne->setFirstName('First name');
            $abonne->setLastName('Last name');
            $abonne->setEnabled(true);

            $manager->persist($abonne);
        
            $abonnes[]  = $abonne;
        }
        
        $manager->flush();
        
        for($i = 0; $i <= 3; $i++)
        {
            $abonne = $abonnes[$i];
            $mask   = $this->createMaskBuilder();
            
            $mask->add(MaskBuilder::MASK_OPERATOR);
            
            $this->container->get('app.security.acl_manager')->insertObjectAce($abonne, $mask, $abonne);

            $this->addReference('abonne' . $i, $abonne);
        }
        
        ###
        # Partner
        ###
        
        $partners = array();
        
        for($i = 0; $i <= 3; $i++)
        {
            $partner        = new Partner();
            $phoneNumber    = $this->container->get('libphonenumber.phone_number_util')->parse(
                    '+3370707070' . $i
                );

            $partner->addRole(User::ROLE_DEFAULT);
            $partner->setUsername('Partner' . $i);
            $partner->setPassword($this->encoder->encodePassword($partner, 'password'));
            $partner->setEmail('partner' . $i . '@nofiplus.com');
            $partner->setGender($i < 2 ? 'male' : 'female');
            $partner->setBirthday(new \DateTime('25-02-1983'));
            $partner->setFirstName('First name');
            $partner->setLastName('Last name');
            $partner->setEnabled(true);
            $partner->setPhone($phoneNumber);

            $manager->persist($partner);
        
            $partners[]  = $partner;
        }
        
        $manager->flush();
        
        for($i = 0; $i <= 3; $i++)
        {
            $partner = $partners[$i];
            $mask   = $this->createMaskBuilder();
            
            $mask->add(MaskBuilder::MASK_OPERATOR);
            
            $this->container->get('app.security.acl_manager')->insertObjectAce($partner, $mask, $partner);

            $this->addReference('partner' . $i, $partner);
        }
    }
}
