<?php

namespace AppBundle\DataFixtures\Admin\Category;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use AppBundle\DataFixtures\DataBaseFixtures;
use AppBundle\Entity\Admin\Category\Carte;
use AppBundle\DataFixtures\User\UserFixtures;

/**
 * Description of CarteFixtures
 *
 * @author Hubsine <contact@hubsine.com>
 */
class CarteFixtures extends DataBaseFixtures implements DependentFixtureInterface
{
    
    public function load(ObjectManager $manager)
    {
        
        ###
        # Carte
        ###
        $carte = new Carte();
        
        $carte->setName('Premium');
        $carte->setAmount(50);
        $carte->setAbout('About premium carte');
        
        $manager->persist($carte);
        $manager->flush();
            
        $this->addReference('carte_premium', $carte);
    }
    
    public function getDependencies()
    {
        return [
            UserFixtures::class
        ];
    }
}
