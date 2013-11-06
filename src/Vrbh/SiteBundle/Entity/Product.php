<?php
namespace Vrbh\SiteBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="product")
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
	
    /**
     * @ORM\ManyToOne(targetEntity="Organisation", inversedBy="products")
     * @ORM\JoinColumn(name="organisation_id", referencedColumnName="id")
     */
    protected $organisation;	
	
	/**
	 * @ORM\Column(type="string", length=255)
	 */
	protected $name;	
	
    /**
     * @ORM\OneToMany(targetEntity="Voorraad", mappedBy="product")
     */	
	protected $voorraden;	
	
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
        
		$this->voorraden = new ArrayCollection();
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
     * Set organisation
     *
     * @param \Vrbh\SiteBundle\Entity\Organisations $organisation
     * @return Products
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
     * Set name
     *
     * @param string $name
     * @return Products
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
     * Add voorraden
     *
     * @param \Vrbh\SiteBundle\Entity\Voorraad $voorraden
     *
     * @return Product
     */
    public function addVoorraden(\Vrbh\SiteBundle\Entity\Voorraad $voorraden)
    {
        $this->voorraden[] = $voorraden;
    
        return $this;
    }

    /**
     * Remove voorraden
     *
     * @param \Vrbh\SiteBundle\Entity\Voorraad $voorraden
     */
    public function removeVoorraden(\Vrbh\SiteBundle\Entity\Voorraad $voorraden)
    {
        $this->voorraden->removeElement($voorraden);
    }

    /**
     * Get voorraden
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVoorraden()
    {
        return $this->voorraden;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Product
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
     * @return Product
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
