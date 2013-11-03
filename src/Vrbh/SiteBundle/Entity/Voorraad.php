<?php
namespace Vrbh\SiteBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="voorraad")
 */
class Voorraad
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
	
    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="voorraden")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    protected $product;	
}
