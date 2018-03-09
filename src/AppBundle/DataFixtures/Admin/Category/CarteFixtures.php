<?php

namespace AppBundle\DataFixtures\Admin\Category;

use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\DataFixtures\DataBaseFixtures;
use AppBundle\Entity\Admin\Category\Carte;

/**
 * Description of CarteFixtures
 *
 * @author Hubsine <contact@hubsine.com>
 */
class CarteFixtures extends DataBaseFixtures
{
    
    public function load(ObjectManager $manager)
    {
        
        ###
        # Carte
        ###
        $carte = new Carte();
        
        $carte->setName('Premium');
        $carte->setPrice(50);
        $carte->setAbout('About premium carte');
        
        $manager->persist($carte);
        $manager->flush();
            
        $this->addReference('carte_premium', $carte);
    }
}
