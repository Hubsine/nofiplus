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
        
        $offresCat  = array('Bon d\'achat', 'Réduction en %', 'Produit offert');
        $offres     = array();
        
        ###
        # Offre
        ###
        
        foreach ($offresCat as $key => $value) 
        {
            $offre = new Offre();
            
            $offre->setName($value);
            $offre->setAbout('About ' . $value);
            
            $manager->persist($offre);
            
            $offres[$key]   = $offre;
        }
        
        $manager->flush();
            
        foreach ($offres as $key => $offre) 
        {
            $this->addReference('cat_offre_' . $key, $offre);
        }
    }
}
