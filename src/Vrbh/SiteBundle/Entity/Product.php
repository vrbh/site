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
}
