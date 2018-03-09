<?php

namespace AppBundle\DataFixtures\Admin\Category;

use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\DataFixtures\DataBaseFixtures;
use AppBundle\Entity\Admin\Category\Offre;

/**
 * Description of OffreFixtures
 *
 * @author Hubsine <contact@hubsine.com>
 */
class OffreFixtures extends DataBaseFixtures
{
    
    public function load(ObjectManager $manager)
    {
        
        $offres  = array('Bon d\'achat', 'Réduction en %', 'Produit offert');
        
        ###
        # Offre
        ###
        
        foreach ($offres as $key => $value) 
        {
            $carte = new Offre();
            
            $carte->setName($value);
            $carte->setAbout('About ' . $value);
            
            $manager->persist($carte);
        }
        
        
        $manager->flush();
            
    }
}
