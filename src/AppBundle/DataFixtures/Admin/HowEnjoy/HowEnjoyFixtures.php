<?php

namespace AppBundle\DataFixtures\Admin\HowEnjoy;

use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\DataFixtures\DataBaseFixtures;
use AppBundle\Entity\Admin\HowEnjoy\HowEnjoy;

/**
 * Description of HowEnjoyFixtures
 *
 * @author Hubsine <contact@hubsine.com>
 */
class HowEnjoyFixtures extends DataBaseFixtures
{
    
    public function load(ObjectManager $manager)
    {
        $enjoyBys = array('location', 'web', 'tel');
        
        ###
        # HowEnjoy
        ###
        
        foreach ($enjoyBys as $value) 
        {
            $howEnjoy = new HowEnjoy();
        
            $howEnjoy->setEnjoyBy($value);

            $manager->persist($howEnjoy);
        }
        
        $manager->flush();
    }
}
