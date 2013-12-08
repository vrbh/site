<?php
namespace Vrbh\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_org")
 * @ORM\HasLifecycleCallbacks()
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
     * @param \Vrbh\SiteBundle\Entity\Organisation $organisation
     * @return UserOrg
     */
    public function setOrganisation(Organisation $organisation = null)
    {
        $this->organisation = $organisation;
    
        return $this;
    }

    /**
     * Get organisation
     *
     * @return \Vrbh\SiteBundle\Entity\Organisation
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
    public function setUser(User $user = null)
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

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return UserOrg
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
     * @return UserOrg
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
