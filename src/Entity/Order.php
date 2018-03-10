<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 * @ORM\Table(name="tbl_order")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", name="order_id")
     */
    private $orderId;


    /**
     * @ORM\Column(name="order_code", type="string", unique=true, nullable=true)
     */
    private $orderCode;

    /**
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cart", inversedBy="orders")
     * @ORM\JoinColumn(name="cart", referencedColumnName="cart_id")
     */
    private $cart;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Address", inversedBy="orders")
     * @ORM\JoinColumn(name="address", referencedColumnName="address_id")
     */
    private $address;

    /**
     * @ORM\Column(name="is_paid", type="boolean")
     */
    private $isPaid;

    /**
     * @ORM\Column(name="is_delivered", type="boolean")
     */
    private $isDelivered;


    public function __construct()
    {
        $this->createdAt = new \DateTime('now');
        $this->isDelivered = false;
        $this->isPaid = false;
    }

    public function getOrderId()
    {
        return $this->orderId;
    }

    public function getOrderCode()
    {
        return $this->orderCode;
    }

    public function setOrderCode($orderCode)
    {
        $this->orderCode = $orderCode;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getCart()
    {
        return $this->cart;
    }

    public function setCart(Cart $cart)
    {
        $this->cart = $cart;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress(Address $address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getIsPaid()
    {
        return $this->isPaid;
    }

    /**
     * @param mixed $isPaid
     */
    public function setIsPaid($isPaid)
    {
        $this->isPaid = $isPaid;
    }

    public function getIsDelivered()
    {
        return $this->isDelivered;
    }

    public function setIsDelivered($isDelivered)
    {
        $this->isDelivered = $isDelivered;
    }


}
