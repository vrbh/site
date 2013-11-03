<?php
namespace Vrbh\SiteBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="organisations")
 */
class Organisation
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
	
    /**
     * @ORM\OneToMany(targetEntity="UserOrg", mappedBy="organisation")
     */	
	protected $users;
	
    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="organisation")
     */	
	protected $products;
	
	
	/**
	 * @ORM\Column(type="string", length=255)
	 */
	protected $name;
	
    public function __construct()
    {
        $this->users = new ArrayCollection();
		$this->products = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Organisations
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add users
     *
     * @param \Vrbh\SiteBundle\Entity\UserOrg $users
     * @return Organisations
     */
    public function addUser(\Vrbh\SiteBundle\Entity\UserOrg $users)
    {
        $this->users[] = $users;
    
        return $this;
    }

    /**
     * Remove users
     *
     * @param \Vrbh\SiteBundle\Entity\UserOrg $users
     */
    public function removeUser(\Vrbh\SiteBundle\Entity\UserOrg $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Add products
     *
     * @param \Vrbh\SiteBundle\Entity\Product $products
     * @return Organisations
     */
    public function addProduct(\Vrbh\SiteBundle\Entity\Product $products)
    {
        $this->products[] = $products;
    
        return $this;
    }

    /**
     * Remove products
     *
     * @param \Vrbh\SiteBundle\Entity\Product $products
     */
    public function removeProduct(\Vrbh\SiteBundle\Entity\Product $products)
    {
        $this->products->removeElement($products);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProducts()
    {
        return $this->products;
    }
}
