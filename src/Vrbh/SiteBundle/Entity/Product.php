<?php
namespace Vrbh\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="product")
 * @ORM\HasLifecycleCallbacks()
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
     * @ORM\Column(type="text", nullable=true);
     *
     */
    protected $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $orderNumber;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $ean;

    /**
     * @ORM\OneToMany(targetEntity="Stock", mappedBy="product")
     */
    protected $stocks;

    /**
     * @ORM\OneToOne(targetEntity="Stock")
     * @ORM\JoinColumn(name="current_stock_id", referencedColumnName="id")
     */
    protected $currentStock;

    /**
	 * @ORM\Column(type="datetime")
	 */
	protected $created;

	/**
	 * @ORM\Column(type="datetime")
	 */
    protected $updated;

    /**
     * @ORM\Column(type="integer", nullable=true);
     */
    protected $stock_unit;

    /**
     * @ORM\Column(type="integer", nullable=true);
     */
    protected $order_unit;

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

        $this->stocks = new ArrayCollection();
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
     * @param \Vrbh\SiteBundle\Entity\Organisation $organisation
     * @return Product
     */
    public function setOrganisation(\Vrbh\SiteBundle\Entity\Organisation $organisation = null)
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
     * Set name
     *
     * @param string $name
     * @return Product
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
     * Add stocks
     *
     * @param \Vrbh\SiteBundle\Entity\Stock $stocks
     *
     * @return Product
     */
    public function addStocks(\Vrbh\SiteBundle\Entity\Stock $stocks)
    {
        $this->stocks[] = $stocks;

        return $this;
    }

    /**
     * Remove stocks
     *
     * @param \Vrbh\SiteBundle\Entity\Stock $stocks
     */
    public function removeStocks(\Vrbh\SiteBundle\Entity\Stock $stocks)
    {
        $this->stocks->removeElement($stocks);
    }

    /**
     * Get stocks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStocks()
    {
        return $this->stocks;
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

    /**
     * Set ean
     *
     * @param integer $ean
     * @return Product
     */
    public function setEan($ean)
    {
        $this->ean = $ean;

        return $this;
    }

    /**
     * Get ean
     *
     * @return integer
     */
    public function getEan()
    {
        return $this->ean;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set orderNumber
     *
     * @param string $orderNumber
     * @return Product
     */
    public function setOrderNumber($orderNumber)
    {
        $this->orderNumber = $orderNumber;

        return $this;
    }

    /**
     * Get orderNumber
     *
     * @return string
     */
    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    /**
     * Set stock_unit
     *
     * @param integer $stockUnit
     * @return Product
     */
    public function setStockUnit($stockUnit)
    {
        $this->stock_unit = $stockUnit;

        return $this;
    }

    /**
     * Get stock_unit
     *
     * @return integer
     */
    public function getStockUnit()
    {
        return $this->stock_unit;
    }

    /**
     * Set order_unit
     *
     * @param integer $orderUnit
     * @return Product
     */
    public function setOrderUnit($orderUnit)
    {
        $this->order_unit = $orderUnit;

        return $this;
    }

    /**
     * Get order_unit
     *
     * @return integer
     */
    public function getOrderUnit()
    {
        return $this->order_unit;
    }

    /**
     * Add stocks
     *
     * @param \Vrbh\SiteBundle\Entity\Stock $stocks
     * @return Product
     */
    public function addStock(\Vrbh\SiteBundle\Entity\Stock $stocks)
    {
        $this->stocks[] = $stocks;

        return $this;
    }

    /**
     * Remove stocks
     *
     * @param \Vrbh\SiteBundle\Entity\Stock $stocks
     */
    public function removeStock(\Vrbh\SiteBundle\Entity\Stock $stocks)
    {
        $this->stocks->removeElement($stocks);
    }

    /**
     * Set currentStock
     *
     * @param \Vrbh\SiteBundle\Entity\Stock $currentStock
     * @return Product
     */
    public function setCurrentStock(\Vrbh\SiteBundle\Entity\Stock $currentStock = null)
    {
        $this->currentStock = $currentStock;

        return $this;
    }

    /**
     * Get currentStock
     *
     * @return \Vrbh\SiteBundle\Entity\Stock
     */
    public function getCurrentStock()
    {
        return $this->currentStock;
    }
}
