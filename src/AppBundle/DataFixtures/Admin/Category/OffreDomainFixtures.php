<?php

namespace AppBundle\DataFixtures\Admin\Category;

use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\DataFixtures\DataBaseFixtures;
use AppBundle\Entity\Admin\Category\OffreDomain;

/**
 * Description of OffreDomainFixtures
 *
 * @author Hubsine <contact@hubsine.com>
 */
class OffreDomainFixtures extends DataBaseFixtures
{
    
    public function load(ObjectManager $manager)
    {
        
        $offresCat  = array('Voyage', 'Mode & beauté', 'Restauration');
        $offres     = array();
        
        ###
        # Offre domain
        ###
        
        foreach ($offresCat as $key => $value) 
        {
            $offre = new OffreDomain();
            
            $offre->setName($value);
            $offre->setAbout('About ' . $value);
            
            $manager->persist($offre);
            
            $offres[$key]   = $offre;
        }
        
        $manager->flush();
            
        foreach ($offres as $key => $offre) 
        {
            $this->addReference('cat_offre_domain_' . $key, $offre);
        }
    }
}
