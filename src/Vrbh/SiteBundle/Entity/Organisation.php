<?php
namespace Vrbh\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * @ORM\Entity
 * @ORM\Table(name="organisations")
 * @ORM\HasLifecycleCallbacks()
 * @ExclusionPolicy("all")
 */
class Organisation
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Expose()
     */
    protected $id;
	
    /**
     * @ORM\OneToMany(targetEntity="UserOrg", mappedBy="organisation", cascade={"remove"})
     */	
	protected $users;
	
    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="organisation", cascade={"remove"})
     */	
	protected $products;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="orgsCreated")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @Expose()
     */
	protected $creator;
	
	/**
	 * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Expose()
	 */
	protected $name;

	/**
	 * @ORM\Column(type="datetime")
     * @Expose()
	 */
	protected $created;

	/**
	 * @ORM\Column(type="datetime")
     * @Expose()
	 */
	protected $updated;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->products = new ArrayCollection();
    }

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
     * Set name
     *
     * @param string $name
     * @return Organisation
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
     * @return Organisation
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
     * @return Organisation
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

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Organisation
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
     * @return Organisation
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

    /**
     * Set creator
     *
     * @param \Vrbh\SiteBundle\Entity\User $creator
     *
     * @return Organisation
     */
    public function setCreator(\Vrbh\SiteBundle\Entity\User $creator = null)
    {
        $this->creator = $creator;
    
        return $this;
    }

    /**
     * Get creator
     *
     * @return \Vrbh\SiteBundle\Entity\User 
     */
    public function getCreator()
    {
        return $this->creator;
    }
}
