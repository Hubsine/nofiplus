<?php

namespace AppBundle\DataFixtures\User;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use AppBundle\DataFixtures\Admin\Category\OffreFixtures;
use AppBundle\DataFixtures\Admin\Category\OffreDomainFixtures;
use AppBundle\Entity\User\User;
use AppBundle\Entity\User\Admin;
use AppBundle\Entity\User\Abonne\Abonne;
use AppBundle\Entity\User\Partner\Partner;
use AppBundle\Entity\User\Partner\Company;
use AppBundle\Entity\User\Partner\Offre;
use AppBundle\Entity\User\Partner\Featured;
use AppBundle\Entity\User\Partner\CompanyLogo;
use AppBundle\DataFixtures\DataBaseFixtures;

/**
 * Description of UserFixtures
 *
 * @author Hubsine <contact@hubsine.com>
 */
class UserFixtures extends DataBaseFixtures 
{
    /** 
     * @var \Symfony\Component\Security\Core\Encoder\UserPasswordEncoder $encoder 
     */
    private $encoder;

    public function __construct() 
    {
        $this->encoder = $this->container->get('security.password_encoder');       
    }
    
    public function load(ObjectManager $manager)
    {
        
        ###
        # Admin
        ###
        $user = new Admin();
        
        $user->addRole(User::ROLE_SUPER_ADMIN);
        $user->setUsername('Super admin');
        $user->setPassword($this->encoder->encodePassword($user, 'M3IVk3MCHI'));
        $user->setEmail('super_admin@nofiplus.com');
        $user->setEnabled(true);

        $manager->persist($user);
        $manager->flush();
            
        $mask = $this->createMaskBuilder();
        $mask->add(MaskBuilder::MASK_OWNER);
        
        $this->aclManager->insertObjectAce($user, $mask, $user);
            
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
            
            $this->aclManager->insertObjectAce($abonne, $mask, $abonne);

            $this->addReference('abonne' . $i, $abonne);
        }
        
        ###
        # Partner
        ###
        
        $partners = array();
        
        for($i = 0; $i <= 3; $i++)
        {
            $partner            = new Partner();
            $phoneNumberMobile  = $this->container->get('libphonenumber.phone_number_util')->parse(
                    '+3370707070' . $i
                );
            $phoneNumberFixed  = $this->container->get('libphonenumber.phone_number_util')->parse(
                    '+3310707070' . $i
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
            $partner->setEnabledByAdmin(rand(0, 1));
            $partner->setPhoneMobile($phoneNumberMobile);
            $partner->setPhoneFixed($phoneNumberFixed);
            
            $this->createCompagny($manager, $partner);

            $manager->persist($partner);
        
            $partners[]  = $partner;
        }
        
        $manager->flush();
        
        for($i = 0; $i <= 3; $i++)
        {
            $partner = $partners[$i];
            $mask   = $this->createMaskBuilder();
            
            $mask->add(MaskBuilder::MASK_OPERATOR);
            
            $this->aclManager->insertObjectAce($partner, $mask, $partner);
            
            foreach ($partner->getCompagnies() as $key => $company) 
            {
                $this->container->get('app.security.acl_manager')->insertObjectAce($company, $mask, $partner);
                $this->container->get('app.security.acl_manager')->insertObjectAce($company->getAddress(), $mask, $partner);
                $this->container->get('app.security.acl_manager')->insertObjectAce($company->getLogo(), $mask, $partner);
                
                foreach ($company->getOffres() as $key => $offre) 
                {
                    $this->aclManager->insertObjectAce($offre, $mask, $partner);
                }
            }

            $this->addReference('partner' . $i, $partner);
        }
    }
    
    private function createCompagny(ObjectManager $manager, Partner $partner)
    {
        for ($i = 0; $i < 3; $i++) 
        {
            $company    = new Company();
            $logo = new CompanyLogo();
            
            $company->setName('Company ' . $i);
            $company->setAbout('Company about ' . $i);
            $company->setAddress($this->createAddress());
            $company->setPartner($partner);
            $company->setCategory($this->getReference('cat_company_' . $i));
            $company->setLogo($logo);
            
            // CompanyLogo
            $logo->setFile($this->createUploadedFile());
            
            
            // Offres
            for($o = 0; $o < 3; $o++)
            {
                $offre      = new Offre();
                $featured   = new Featured();
                
                $offre->setName('Offre ' . $o);
                $offre->setAbout('About offre ' . $o);
                $offre->setCategory($this->getReference( 'cat_offre_' . $o ) );
                $offre->setOffreDomain($this->getReference( 'cat_offre_domain_' . $o ) );
                
                // Featured
                $featured->setOffre($offre);
                $featured->setFile($this->createUploadedFile());
                
                $offre->setFeatured($featured);
                
                switch ($o)
                {
                    case 0:
                        $offre->setHowEnjoy([Offre::ENJOY_BY_ALL]);
                        $offre->setEnjoyByLocation('About enjoy by location.');
                        $offre->setEnjoyByTel('About enjoy by tel.');
                        $offre->setEnjoyByWeb('About enjoy by web.');
                        break;
                    
                    case 1:
                        $offre->setHowEnjoy([Offre::ENJOY_BY_LOCATION]);
                        $offre->setEnjoyByLocation('About enjoy by location.');
                        break;
                    
                    case 2:
                        $offre->setHowEnjoy([Offre::ENJOY_BY_WEB, Offre::ENJOY_BY_TEL]);
                        $offre->setEnjoyByTel('About enjoy by tel.');
                        $offre->setEnjoyByWeb('About enjoy by web.');
                        break;
                }
                
                $company->addOffre($offre);
            }
            
            $partner->addCompany($company);
        }
        
    }
    
    public function getDependencies()
    {
        return [
            OffreFixtures::class,
            OffreDomainFixtures::class
        ];
    }
}
