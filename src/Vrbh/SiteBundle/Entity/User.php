<?php
namespace Vrbh\SiteBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
	
    /**
     * @ORM\OneToMany(targetEntity="UserOrg", mappedBy="user")
     */	
	protected $orgs;	
	
    /**
     * @ORM\OneToMany(targetEntity="Organisation", mappedBy="creator")
     */	
	protected $orgsCreated;	
	
	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $created;

	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $updated;	
	
	/**
	 * @ORM\PrePersist
	 */
	public function setCreatedAtValue()
	{
		$this->created = new \DateTime();
		$this->updated = new \DateTime();
	}	

	/**
	 * @ORM\PreUpdate
	 */
	public function setUpdatedAtValue()
	{
		$this->updated = new \DateTime();
	}	

    public function __construct()
    {
        parent::__construct();
        
		$this->orgs = new ArrayCollection();
    }

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
     * Add orgs
     *
     * @param \Vrbh\SiteBundle\Entity\UserOrg $orgs
     * @return User
     */
    public function addOrg(\Vrbh\SiteBundle\Entity\UserOrg $orgs)
    {
        $this->orgs[] = $orgs;
    
        return $this;
    }

    /**
     * Remove orgs
     *
     * @param \Vrbh\SiteBundle\Entity\UserOrg $orgs
     */
    public function removeOrg(\Vrbh\SiteBundle\Entity\UserOrg $orgs)
    {
        $this->orgs->removeElement($orgs);
    }

    /**
     * Get orgs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrgs()
    {
        return $this->orgs;
    }

    /**
     * Add orgsCreated
     *
     * @param \Vrbh\SiteBundle\Entity\Organisation $orgsCreated
     *
     * @return User
     */
    public function addOrgsCreated(\Vrbh\SiteBundle\Entity\Organisation $orgsCreated)
    {
        $this->orgsCreated[] = $orgsCreated;
    
        return $this;
    }

    /**
     * Remove orgsCreated
     *
     * @param \Vrbh\SiteBundle\Entity\Organisation $orgsCreated
     */
    public function removeOrgsCreated(\Vrbh\SiteBundle\Entity\Organisation $orgsCreated)
    {
        $this->orgsCreated->removeElement($orgsCreated);
    }

    /**
     * Get orgsCreated
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrgsCreated()
    {
        return $this->orgsCreated;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return User
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return User
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    
        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }
}
