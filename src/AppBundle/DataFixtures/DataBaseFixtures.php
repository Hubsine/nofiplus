<?php

namespace AppBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

/**
 * Description of DataBaseFixtures
 *
 * @author Hubsine <contact@hubsine.com>
 */
abstract class DataBaseFixtures extends Fixture implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface $container
     */
    protected $container;
    
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    
    /**
     * Get new instance of MaskBuilder
     * 
     * @return MaskBuilder
     */
    public function createMaskBuilder()
    {
        return new MaskBuilder();
    }
}
