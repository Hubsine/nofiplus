<?php

namespace AppBundle\DataFixtures\Admin\Category;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use AppBundle\DataFixtures\DataBaseFixtures;
use AppBundle\Entity\Admin\Category\Company;

/**
 * Description of CompanyFixtures
 *
 * @author Hubsine <contact@hubsine.com>
 */
class CompanyFixtures extends DataBaseFixtures implements DependentFixtureInterface
{
    
    public function load(ObjectManager $manager)
    {
        $companyCat    = array('Voyage', 'Réstauration', 'Mode & Beauté');
        $compagnies     = array();
        
        ###
        # Company
        ###
        
        foreach ($companyCat as $key => $value) 
        {
            $company = new Company();
        
            $company->setName($value);
            $company->setAbout('About ' . $value);
            
            $manager->persist($company);
            
            $compagnies[$key]   = $company;
        }
        
        $manager->flush();
        
        foreach ($compagnies as $key => $value) 
        {
            $this->addReference('cat_company_' . $key, $value);
        }
            
    }
    
    public function getDependencies()
    {
        return [
            UserFixtures::class
        ];
    }
}
