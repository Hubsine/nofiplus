<?php

namespace AppBundle\Entity\Admin\HowEnjoy;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\AdminEntityInterface;
use AppBundle\Entity\Admin\HowEnjoy\AbstractHowEnjoy;

/**
 * Web
 *
 * @ORM\Table(name="np_how_enjoy_by_web")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Admin\HowEnjoy\WebRepository")
 */
class Web extends AbstractHowEnjoy implements AdminEntityInterface
{
    CONST ROUTE_PREFIX = 'how_enjoy_web';
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     * 
     * @Assert\Url(
     *      protocols={"https", "https"}, 
     *      checkDNS=true, 
     *      message="assert.url.invalid",
     *      dnsMessage="assert.url.dns_check"
     * )
     */
    private $url;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Web
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
}

