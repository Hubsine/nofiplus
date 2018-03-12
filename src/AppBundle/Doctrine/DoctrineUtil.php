<?php

namespace AppBundle\Doctrine;

use Symfony\Component\Process\Exception\LogicException;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\EntityInterface;

/**
 * Description of DoctrineUtil
 *
 * @author Hubsine <contact@hubsine.com>
 */
class DoctrineUtil 
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    
    /**
     * Constructor
     * 
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em) 
    {
        $this->em = $em;
    }

    /**
     * Get a persistable repo
     * 
     * @param string $className
     * @return \Doctrine\Common\Persistence\ObjectRepository
     * @throws LogicException
     */
    public function getRepository($className)
    {
        if( !class_exists($className) )
        {
            throw new LogicException(sprintf('Class with class name "%s" does not exist', $className));
        }
        
        return $this->em->getRepository($className);
    }
    
    /**
     * Persist a persistable doctrine entity
     * 
     * @param EntityInterface $persistentObject
     * @param  boolean $flush
     */
    public function persist(EntityInterface $persistentObject, $flush = true)
    {
        $this->em->persist($persistentObject);
        
        if( $flush )
        {
            $this->flush();
        }
    }
    
    /**
     * Remove a persistable doctrine entity
     * 
     * @param EntityInterface $persistentObject
     * @param bollean $flush
     */
    public function remove(EntityInterface $persistentObject, $flush = true)
    {
        $this->em->remove($persistentObject);
        
        if( $flush )
        {
            $this->flush();
        }
    }
    
    /**
     * Flush persistent Object
     */
    public function flush()
    {
        $this->em->flush();
    }
    
    /**
     * Merge $persistentObject
     * 
     * @param EntityInterface $persistentObject
     */
    public function merge(EntityInterface $persistentObject, $flush = true)
    {
        $this->em->merge($persistentObject);
        
        if( $flush )
        {
            $this->flush();
        }
    }
}
