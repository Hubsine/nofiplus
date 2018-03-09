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
        $compagnyCat    = array('Voyage', 'Réstauration', 'Mode & Beauté');
        $compagnies     = array();
        
        ###
        # Compagny
        ###
        
        foreach ($compagnyCat as $key => $value) 
        {
            $compagny = new Compagny();
        
            $compagny->setName($value);
            $compagny->setAbout('About ' . $value);
            
            $manager->persist($compagny);
            
            $compagnies[$key]   = $compagny;
        }
        
        $manager->flush();
        
        foreach ($compagnies as $key => $value) 
        {
            $this->addReference('cat_compagny_' . $key, $value);
        }
            
    }
}
