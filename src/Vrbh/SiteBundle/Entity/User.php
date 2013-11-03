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
}
