<?php
namespace Vrbh\SiteBundle\Entity;

use FOS\OAuthServerBundle\Entity\RefreshToken as BaseRefreshToken;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class RefreshToken extends BaseRefreshToken
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $client;

    /**
     * @ORM\ManyToOne(targetEntity="Vrbh\SiteBundle\Entity\User")
     */
    protected $user;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set client
     *
     * @param \Vrbh\SiteBundle\Entity\Client $client
     *
     * @return RefreshToken
     */
    public function setClient(\FOS\OAuthServerBundle\Model\ClientInterface $client)
    {
        $this->client = $client;
    
        return $this;
    }

    /**
     * Get client
     *
     * @return \Vrbh\SiteBundle\Entity\Client 
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set user
     *
     * @param \Vrbh\SiteBundle\Entity\User $user
     *
     * @return RefreshToken
     */
    public function setUser(\Symfony\Component\Security\Core\User\UserInterface $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Vrbh\SiteBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
