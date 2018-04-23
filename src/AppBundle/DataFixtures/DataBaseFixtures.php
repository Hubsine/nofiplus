<?php

namespace AppBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use AppBundle\Entity\Address;
use AppBundle\Security\AclSecurityManager;

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

    /**
     * @var AclSecurityManager
     */
    protected $aclManager;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container    = $container;
        $this->aclManager   = $this->container->get('app.security.acl_manager');
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
    
    /**
     * Create address
     * 
     * @return Address
     */
    protected function createAddress()
    {
        $address = new Address();
        
        $address->setAddress('1 rue de la croix');
        $address->setCity('Paris');
        $address->setZipCode('75001');
        $address->setCountry('fr');
        
        return $address;
    }
    
    /**
     * Create UploadedFIle
     * 
     * @return UploadedFile
     */
    protected function createUploadedFile()
    {
        $src    = $this->container->getParameter('kernel.project_dir') . '/assets/images/default_nofiplus_logo.png';
        $dest   = $this->container->getParameter('kernel.project_dir') . '/web/uploads/fixtures';
        
        if( !file_exists($dest) )
        {
            $mkdir  = mkdir($dest, 0777, true);
            if( ! $mkdir ) return false;
        }
        
        $copy = copy($src, $dest = $dest . '/' .uniqid() . '_default_nofiplus_logo.png');
        
        if( $copy )
        {
            $file = new UploadedFile(
                $dest,
                'default_nofiplus_logo.png',
                'image/png',
                filesize($dest),
                null, 
                true // => dev mode 
            );
        
            return $file;
        }
        
        return false;
    }
}
