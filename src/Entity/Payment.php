<?php
/**
 * Created by PhpStorm.
 * User: Mouncef
 * Date: 22/04/2018
 * Time: 18:29
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Payement
 * @package App\Entity
 * @ORM\Table(name="tbl_payement")
 * @ORM\Entity()
 */
class Payment
{
    /**
     * @ORM\Column(name="payement_id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $payementId;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Order", mappedBy="payment")
     */
    private $orders;

    /**
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(name="state", type="string", nullable=true)
     */
    private $state;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PayPalDetail", inversedBy="payments")
     * @ORM\JoinColumn(name="paypal_detail", referencedColumnName="pay_pal_detail_id")
     */
    private $paypalDetail;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\BrainTreeDetail", inversedBy="payments")
     * @ORM\JoinColumn(name="braintree_detail", referencedColumnName="brain_tree_detail_id")
     */
    private $braintreeDetail;

    public function __construct()
    {
        $this->orders = new ArrayCollection();

    }

    /**
     * @return mixed
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * @param mixed $orders
     */
    public function setOrders($orders)
    {
        $this->orders = $orders;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return mixed
     */
    public function getPaypalDetail()
    {
        return $this->paypalDetail;
    }

    /**
     * @param mixed $paypalDetail
     */
    public function setPaypalDetail($paypalDetail)
    {
        $this->paypalDetail = $paypalDetail;
    }

    /**
     * @return mixed
     */
    public function getBraintreeDetail()
    {
        return $this->braintreeDetail;
    }

    /**
     * @param mixed $braintreeDetail
     */
    public function setBraintreeDetail($braintreeDetail)
    {
        $this->braintreeDetail = $braintreeDetail;
    }


}