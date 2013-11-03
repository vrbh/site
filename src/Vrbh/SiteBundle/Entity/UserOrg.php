<?php
namespace Vrbh\SiteBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_org")
 */
class UserOrg
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
	
    /**
     * @ORM\ManyToOne(targetEntity="Organisation", inversedBy="users")
     * @ORM\JoinColumn(name="organisation_id", referencedColumnName="id")
     */
    protected $organisation;	
	
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="orgs")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;		
	
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $type;


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
     * Set type
     *
     * @param string $type
     * @return UserOrg
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set organisation
     *
     * @param \Vrbh\SiteBundle\Entity\Organisations $organisation
     * @return UserOrg
     */
    public function setOrganisation(\Vrbh\SiteBundle\Entity\Organisations $organisation = null)
    {
        $this->organisation = $organisation;
    
        return $this;
    }

    /**
     * Get organisation
     *
     * @return \Vrbh\SiteBundle\Entity\Organisations 
     */
    public function getOrganisation()
    {
        return $this->organisation;
    }

    /**
     * Set user
     *
     * @param \Vrbh\SiteBundle\Entity\User $user
     * @return UserOrg
     */
    public function setUser(\Vrbh\SiteBundle\Entity\User $user = null)
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
