<?php
namespace Vrbh\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Type;
/**
 * @ORM\Entity
 * @ORM\Table(name="product")
 * @ORM\HasLifecycleCallbacks()
 * @ExclusionPolicy("all")
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Expose()
     */
    protected $id;
	
    /**
     * @ORM\ManyToOne(targetEntity="Organisation", inversedBy="products")
     * @ORM\JoinColumn(name="organisation_id", referencedColumnName="id")
     * @Expose()
     */
    protected $organisation;	
	
	/**
	 * @ORM\Column(type="string", length=255)
     * @Expose()
	 */
    protected $name;

    /**
     * @ORM\Column(type="text", nullable=true);
     * @Expose()
     *
     */
    protected $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Expose()
     */
    protected $orderNumber;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Expose()
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
     * @Type("DateTime<'Y-m-d\TH:i:s'>")
     * @Expose()
	 */
	protected $created;

	/**
	 * @ORM\Column(type="datetime")
     * @Type("DateTime<'Y-m-d\TH:i:s'>")
     * @Expose()
	 */
    protected $updated;

    /**
     * @ORM\Column(type="string", length=255, nullable=true);
     * @Expose()
     */
    protected $stockUnit;

    /**
     * @ORM\Column(type="string", length=255, nullable=true);
     * @Expose()
     */
    protected $orderUnit;

    /**
     * @ORM\Column(type="integer")
     * @Expose()
     */
    protected $minStock;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Expose()
     */
    protected $maxStock;

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
    public function addStocks(Stock $stocks)
    {
        $this->stocks[] = $stocks;

        return $this;
    }

    /**
     * Remove stocks
     *
     * @param \Vrbh\SiteBundle\Entity\Stock $stocks
     */
    public function removeStocks(Stock $stocks)
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
     * @param String $stockUnit
     * @return Product
     */
    public function setStockUnit($stockUnit)
    {
        $this->stockUnit = $stockUnit;

        return $this;
    }

    /**
     * Get stock_unit
     *
     * @return String
     */
    public function getStockUnit()
    {
        return $this->stockUnit;
    }

    /**
     * Set order_unit
     *
     * @param String $orderUnit
     * @return Product
     */
    public function setOrderUnit($orderUnit)
    {
        $this->orderUnit = $orderUnit;

        return $this;
    }

    /**
     * Get order_unit
     *
     * @return String
     */
    public function getOrderUnit()
    {
        return $this->orderUnit;
    }

    /**
     * Add stocks
     *
     * @param \Vrbh\SiteBundle\Entity\Stock $stocks
     * @return Product
     */
    public function addStock(Stock $stocks)
    {
        $this->stocks[] = $stocks;

        return $this;
    }

    /**
     * Remove stocks
     *
     * @param \Vrbh\SiteBundle\Entity\Stock $stocks
     */
    public function removeStock(Stock $stocks)
    {
        $this->stocks->removeElement($stocks);
    }

    /**
     * Set currentStock
     *
     * @param \Vrbh\SiteBundle\Entity\Stock $currentStock
     * @return Product
     */
    public function setCurrentStock(Stock $currentStock = null)
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

    /**
     * Set minStock
     *
     * @param integer $minStock
     * @return Product
     */
    public function setMinStock($minStock)
    {
        $this->minStock = $minStock;

        return $this;
    }

    /**
     * Get minStock
     *
     * @return integer 
     */
    public function getMinStock()
    {
        return $this->minStock;
    }

    /**
     * Set maxStock
     *
     * @param integer $maxStock
     * @return Product
     */
    public function setMaxStock($maxStock)
    {
        $this->maxStock = $maxStock;

        return $this;
    }

    /**
     * Get maxStock
     *
     * @return integer 
     */
    public function getMaxStock()
    {
        return $this->maxStock;
    }
}
