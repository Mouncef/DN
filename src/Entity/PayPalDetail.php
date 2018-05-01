<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PayPalDetailRepository")
 * @ORM\Table(name="tbl_pay_pal_detail")
 */
class PayPalDetail
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", name="pay_pal_detail_id")
     */
    private $payPalDetailId;

    /**
     * @ORM\Column(name="paypal_payment_id", type="string", length=255, nullable=true)
     */
    private $paypalPaymentId;

    /**
     * @ORM\Column(name="paypal_token", type="string", length=255, nullable=true)
     */
    private $paypalToken;

    /**
     * @ORM\Column(name="paypal_payer_id", type="string", length=255, nullable=true)
     */
    private $paypalPayerId;

    /**
     * @ORM\Column(name="paypal_payer_mail", type="string", length=255, nullable=true)
     */
    private $paypalPayerMail;

    /**
     * @ORM\Column(name="paypal_payer_first_name", type="string", length=255, nullable=true)
     */
    private $paypalPayerFirstName;

    /**
     * @ORM\Column(name="paypal_payer_last_name", type="string", length=255, nullable=true)
     */
    private $paypalPayerLastName;


    /**
     * @ORM\Column(name="paypal_total", type="float", nullable=true)
     */
    private $paypalTotal;

    /**
     * @ORM\Column(name="paypal_currency", type="string", length=255, nullable=true)
     */
    private $paypalCurrency;

    /**
     * @ORM\Column(name="paypal_sub_total", type="float", nullable=true)
     */
    private $paypalSubTotal;

    /**
     * @ORM\Column(name="paypal_merchant", type="string", length=255, nullable=true)
     */
    private $paypalMerchant;

    /**
     * @ORM\Column(name="paypal_merchant_mail", type="string", length=255, nullable=true)
     */
    private $paypalMerchantMail;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Payment", mappedBy="paypalDetail")
     */
    private $payments;

    public function __construct()
    {
        $this->payments = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getPaypalPaymentId()
    {
        return $this->paypalPaymentId;
    }

    /**
     * @param mixed $paypalPaymentId
     */
    public function setPaypalPaymentId($paypalPaymentId)
    {
        $this->paypalPaymentId = $paypalPaymentId;
    }

    /**
     * @return mixed
     */
    public function getPaypalToken()
    {
        return $this->paypalToken;
    }

    /**
     * @param mixed $paypalToken
     */
    public function setPaypalToken($paypalToken)
    {
        $this->paypalToken = $paypalToken;
    }

    /**
     * @return mixed
     */
    public function getPaypalPayerId()
    {
        return $this->paypalPayerId;
    }

    /**
     * @param mixed $paypalPayerId
     */
    public function setPaypalPayerId($paypalPayerId)
    {
        $this->paypalPayerId = $paypalPayerId;
    }

    /**
     * @return mixed
     */
    public function getPaypalTotal()
    {
        return $this->paypalTotal;
    }

    /**
     * @param mixed $paypalTotal
     */
    public function setPaypalTotal($paypalTotal)
    {
        $this->paypalTotal = $paypalTotal;
    }

    /**
     * @return mixed
     */
    public function getPaypalCurrency()
    {
        return $this->paypalCurrency;
    }

    /**
     * @param mixed $paypalCurrency
     */
    public function setPaypalCurrency($paypalCurrency)
    {
        $this->paypalCurrency = $paypalCurrency;
    }

    /**
     * @return mixed
     */
    public function getPaypalSubTotal()
    {
        return $this->paypalSubTotal;
    }

    /**
     * @param mixed $paypalSubTotal
     */
    public function setPaypalSubTotal($paypalSubTotal)
    {
        $this->paypalSubTotal = $paypalSubTotal;
    }

    /**
     * @return mixed
     */
    public function getPaypalMerchant()
    {
        return $this->paypalMerchant;
    }

    /**
     * @param mixed $paypalMerchant
     */
    public function setPaypalMerchant($paypalMerchant)
    {
        $this->paypalMerchant = $paypalMerchant;
    }

    /**
     * @return mixed
     */
    public function getPaypalMerchantMail()
    {
        return $this->paypalMerchantMail;
    }

    /**
     * @param mixed $paypalMerchantMail
     */
    public function setPaypalMerchantMail($paypalMerchantMail)
    {
        $this->paypalMerchantMail = $paypalMerchantMail;
    }

    /**
     * @return mixed
     */
    public function getPayments()
    {
        return $this->payments;
    }

    /**
     * @param mixed $payments
     */
    public function setPayments($payments)
    {
        $this->payments = $payments;
    }

    /**
     * @return mixed
     */
    public function getPaypalPayerMail()
    {
        return $this->paypalPayerMail;
    }

    /**
     * @param mixed $paypalPayerMail
     */
    public function setPaypalPayerMail($paypalPayerMail)
    {
        $this->paypalPayerMail = $paypalPayerMail;
    }

    /**
     * @return mixed
     */
    public function getPaypalPayerFirstName()
    {
        return $this->paypalPayerFirstName;
    }

    /**
     * @param mixed $paypalPayerFirstName
     */
    public function setPaypalPayerFirstName($paypalPayerFirstName)
    {
        $this->paypalPayerFirstName = $paypalPayerFirstName;
    }

    /**
     * @return mixed
     */
    public function getPaypalPayerLastName()
    {
        return $this->paypalPayerLastName;
    }

    /**
     * @param mixed $paypalPayerLastName
     */
    public function setPaypalPayerLastName($paypalPayerLastName)
    {
        $this->paypalPayerLastName = $paypalPayerLastName;
    }

    /**
     * @return mixed
     */
    public function getPayPalDetailId()
    {
        return $this->payPalDetailId;
    }



}
