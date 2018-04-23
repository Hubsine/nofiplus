<?php

namespace AppBundle\DataFixtures\Admin\Pages;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use AppBundle\DataFixtures\DataBaseFixtures;
use AppBundle\Entity\Admin\Pages\Page;
use AppBundle\Entity\Admin\Pages\Maintenance;

/**
 * Description of PagesFixtures
 *
 * @author Hubsine <contact@hubsine.com>
 */
class PagesFixtures extends DataBaseFixtures
{
    public static $longText = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam lorem urna, vehicula eget dolor sed, pulvinar ullamcorper mi. Donec hendrerit volutpat diam non efficitur. Ut rhoncus, libero in hendrerit pellentesque, ante nisi faucibus lorem, vel sollicitudin nunc ligula vel massa. Vivamus congue arcu ante, ut mollis eros elementum ac. Nullam ut egestas orci. Mauris gravida velit sed aliquam condimentum. Sed commodo dapibus justo, vel sollicitudin metus tempor porta. Proin dapibus consequat ante. Donec condimentum leo maximus erat gravida placerat.

Cras malesuada risus vel tellus posuere, in dapibus felis placerat. Morbi lobortis lacus varius, suscipit augue nec, ultricies mauris. Morbi quis elit vel lorem malesuada pulvinar. Quisque lobortis ultrices tristique. Aenean dictum, mi in sodales egestas, augue ante tincidunt mauris, varius sodales elit tellus eu est. Sed fermentum aliquet lacus et consequat. Curabitur maximus ut mauris sed lobortis. Etiam egestas laoreet rhoncus. Sed tincidunt vel felis vitae bibendum. Phasellus quis arcu sit amet lorem tempor pretium eu et tellus.';
    
    public function load(ObjectManager $manager)
    {
        $this->createContactPage($manager);
        $this->createCgvPage($manager);
        $this->createMentionsLegalesPage($manager);
        $this->createMaintenancePage($manager);
        
        $manager->flush();
    }
    
    private function createContactPage(ObjectManager $manager)
    {
        $contactPage = new Page();
        
        $contactPage->setTitle('Contact');
        $contactPage->setContent(self::$longText);
        $contactPage->setLocale('fr');
        $contactPage->setLabel('Contact');
        $contactPage->setUniqueStringId('contact');
        
        $manager->persist($contactPage);
        
    }
    
    private function createCgvPage(ObjectManager $manager)
    {
        $cgvPage = new Page();
        
        $cgvPage->setTitle('Cgv');
        $cgvPage->setContent(self::$longText);
        $cgvPage->setLocale('fr');
        $cgvPage->setLabel('Cgv');
        $cgvPage->setUniqueStringId('cgv');
        
        $manager->persist($cgvPage);
        
    }
    
    private function createMentionsLegalesPage(ObjectManager $manager)
    {
        $mentionsLegalesPage = new Page();
        
        $mentionsLegalesPage->setTitle('Mentions legales');
        $mentionsLegalesPage->setContent(self::$longText);
        $mentionsLegalesPage->setLocale('fr');
        $mentionsLegalesPage->setLabel('Mentions legales');
        $mentionsLegalesPage->setUniqueStringId('mentions-legales');
        
        $manager->persist($mentionsLegalesPage);
    }
    
    public function createMaintenancePage(ObjectManager $manager)
    {
        $maintenancePage    = new Maintenance();
        
        $maintenancePage->setContent('Maintenance mode enabled.');
        $maintenancePage->setTitle('Mainetance mode');
        $maintenancePage->setLocale('fr');
        
        $manager->persist($maintenancePage);
    }
}
