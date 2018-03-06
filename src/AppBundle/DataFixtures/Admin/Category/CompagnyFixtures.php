<?php

namespace AppBundle\DataFixtures\Admin\Category;

use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\DataFixtures\DataBaseFixtures;
use AppBundle\Entity\Admin\Category\Compagny;

/**
 * Description of CompagnyFixtures
 *
 * @author Hubsine <contact@hubsine.com>
 */
class CompagnyFixtures extends DataBaseFixtures
{
    
    public function load(ObjectManager $manager)
    {
        $compagny   = array('Voyage', 'Réstauration', 'Mode & Beauté');
        
        ###
        # Compagny
        ###
        
        foreach ($compagny as $value) 
        {
            $carte = new Compagny();
        
            $carte->setName($value);
            $carte->setAbout('About ' . $value);
            
            $manager->persist($carte);
        }
        
        $manager->flush();
            
    }
}
