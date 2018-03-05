<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationControllerTest extends WebTestCase
{
    public function testRegister()
    {
        $client = self::createClient();
        
        // Init
        $crawler = $client->request('GET', '/register/');
        $this->assertTrue($client->getResponse()->isSuccessful());

        ###
        # Form
        ###
        //$form = $crawler->selectButton('submit')->form();
        //$crawler = $client->submit($form);
        
    }
}
