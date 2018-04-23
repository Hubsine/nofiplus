<?php

namespace AppBundle\DataFixtures\Admin;

use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\DataFixtures\DataBaseFixtures;
use AppBundle\Entity\Contact;

/**
 * Description of ContactMessagesFixtures
 *
 * @author Hubsine <contact@hubsine.com>
 */
class ContactMessagesFixtures extends DataBaseFixtures
{
    public function load(ObjectManager $manager)
    {
        for($c = 0; $o < 3; $o++)
        {
            $contact = new Contact();
            
            $contact->setFromEmail('fakeemail' . $c . '@fakeemail.com');
            $contact->setFromName('Fake email ' . $c);
            $contact->setMessage('Message content');
            $contact->setSubject('Subject message');
            
            $manager->persist($contact);
        }
        
        $manager->flush();
    }
}
