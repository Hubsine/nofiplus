<?php

namespace AppBundle\DataFixtures\Admin\Category;

use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\DataFixtures\DataBaseFixtures;
use AppBundle\Entity\Admin\Category\Advantage;

/**
 * Description of AdvantageFixtures
 *
 * @author Hubsine <contact@hubsine.com>
 */
class AdvantageFixtures extends DataBaseFixtures
{
    
    public function load(ObjectManager $manager)
    {
        
        $advantages  = array('Bon d\'achat', 'Réduction en %', 'Produit offert');
        
        ###
        # Advantage
        ###
        
        foreach ($advantages as $key => $value) 
        {
            $carte = new Advantage();
            
            $carte->setName($value);
            $carte->setAbout('About ' . $value);
            
            $manager->persist($carte);
        }
        
        
        $manager->flush();
            
    }
}
