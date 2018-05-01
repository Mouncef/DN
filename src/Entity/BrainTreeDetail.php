<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BrainTreeDetailRepository")
 * @ORM\Table(name="tbl_brain_tree_detail")
 */
class BrainTreeDetail
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", name="brain_tree_detail_id")
     */
    private $brainTreeDetailId;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Payment", mappedBy="braintreeDetail")
     */
    private $payments;

    /**
     * @ORM\Column(name="braintree_result_state", type="boolean", nullable=true)
     */
    private $braintreeResultState;

    /**
     * @ORM\Column(name="braintree_transaction_id", type="string", length=255, nullable=true)
     */
    private $braintreeTransactionId;

    /**
     * @ORM\Column(name="braintree_transaction_state", type="string", length=255, nullable=true)
     */
    private $braintreeTransactionState;

    /**
     * @ORM\Column(name="braintree_transaction_type", type="string", length=255, nullable=true)
     */
    private $braintreeTransactionType;

    /**
     * @ORM\Column(name="braintree_transaction_amount", type="float", nullable=true)
     */
    private $braintreeTransactionAmount;

    /**
     * @ORM\Column(name="braintree_transaction_created_at", type="datetime", nullable=true)
     */
    private $braintreeTransactionCreatedAt;

    /**
     * @ORM\Column(name="braintree_transaction_card_bin", type="string", length=50, nullable=true)
     */
    private $braintreeTransactionCardBin;

    /**
     * @ORM\Column(name="braintree_transaction_card_four_last", type="string", length=20, nullable=true)
     */
    private $braintreeTransactionCardFourLast;

    /**
     * @ORM\Column(name="braintree_transaction_card_type", type="string", length=50, nullable=true)
     */
    private $braintreeTransactionCardType;

    /**
     * @ORM\Column(name="braintree_transaction_card_expired_at", type="string", length=50, nullable=true)
     */
    private $braintreeTransactionCardExpiredAt;

    /**
     * @ORM\Column(name="braintree_transaction_card_masked_number", type="string", length=50, nullable=true)
     */
    private $braintreeTransactionCardMaskedNumber;

    /**
     * @ORM\Column(name="braintree_transaction_customer_location", type="string", length=50, nullable=true )
     */
    private $braintreeTransactionCustomerLocation;

    public function __construct()
    {
        $this->payments = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getBrainTreeDetailId()
    {
        return $this->brainTreeDetailId;
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
    public function getBraintreeResultState()
    {
        return $this->braintreeResultState;
    }

    /**
     * @param mixed $braintreeResultState
     */
    public function setBraintreeResultState($braintreeResultState)
    {
        $this->braintreeResultState = $braintreeResultState;
    }

    /**
     * @return mixed
     */
    public function getBraintreeTransactionId()
    {
        return $this->braintreeTransactionId;
    }

    /**
     * @param mixed $braintreeTransactionId
     */
    public function setBraintreeTransactionId($braintreeTransactionId)
    {
        $this->braintreeTransactionId = $braintreeTransactionId;
    }

    /**
     * @return mixed
     */
    public function getBraintreeTransactionState()
    {
        return $this->braintreeTransactionState;
    }

    /**
     * @param mixed $braintreeTransactionState
     */
    public function setBraintreeTransactionState($braintreeTransactionState)
    {
        $this->braintreeTransactionState = $braintreeTransactionState;
    }

    /**
     * @return mixed
     */
    public function getBraintreeTransactionType()
    {
        return $this->braintreeTransactionType;
    }

    /**
     * @param mixed $braintreeTransactionType
     */
    public function setBraintreeTransactionType($braintreeTransactionType)
    {
        $this->braintreeTransactionType = $braintreeTransactionType;
    }

    /**
     * @return mixed
     */
    public function getBraintreeTransactionAmount()
    {
        return $this->braintreeTransactionAmount;
    }

    /**
     * @param mixed $braintreeTransactionAmount
     */
    public function setBraintreeTransactionAmount($braintreeTransactionAmount)
    {
        $this->braintreeTransactionAmount = $braintreeTransactionAmount;
    }

    /**
     * @return mixed
     */
    public function getBraintreeTransactionCreatedAt()
    {
        return $this->braintreeTransactionCreatedAt;
    }

    /**
     * @param mixed $braintreeTransactionCreatedAt
     */
    public function setBraintreeTransactionCreatedAt($braintreeTransactionCreatedAt)
    {
        $this->braintreeTransactionCreatedAt = $braintreeTransactionCreatedAt;
    }

    /**
     * @return mixed
     */
    public function getBraintreeTransactionCardBin()
    {
        return $this->braintreeTransactionCardBin;
    }

    /**
     * @param mixed $braintreeTransactionCardBin
     */
    public function setBraintreeTransactionCardBin($braintreeTransactionCardBin)
    {
        $this->braintreeTransactionCardBin = $braintreeTransactionCardBin;
    }

    /**
     * @return mixed
     */
    public function getBraintreeTransactionCardFourLast()
    {
        return $this->braintreeTransactionCardFourLast;
    }

    /**
     * @param mixed $braintreeTransactionCardFourLast
     */
    public function setBraintreeTransactionCardFourLast($braintreeTransactionCardFourLast)
    {
        $this->braintreeTransactionCardFourLast = $braintreeTransactionCardFourLast;
    }

    /**
     * @return mixed
     */
    public function getBraintreeTransactionCardType()
    {
        return $this->braintreeTransactionCardType;
    }

    /**
     * @param mixed $braintreeTransactionCardType
     */
    public function setBraintreeTransactionCardType($braintreeTransactionCardType)
    {
        $this->braintreeTransactionCardType = $braintreeTransactionCardType;
    }

    /**
     * @return mixed
     */
    public function getBraintreeTransactionCardExpiredAt()
    {
        return $this->braintreeTransactionCardExpiredAt;
    }

    /**
     * @param mixed $braintreeTransactionCardExpiredAt
     */
    public function setBraintreeTransactionCardExpiredAt($braintreeTransactionCardExpiredAt)
    {
        $this->braintreeTransactionCardExpiredAt = $braintreeTransactionCardExpiredAt;
    }

    /**
     * @return mixed
     */
    public function getBraintreeTransactionCardMaskedNumber()
    {
        return $this->braintreeTransactionCardMaskedNumber;
    }

    /**
     * @param mixed $braintreeTransactionCardMaskedNumber
     */
    public function setBraintreeTransactionCardMaskedNumber($braintreeTransactionCardMaskedNumber)
    {
        $this->braintreeTransactionCardMaskedNumber = $braintreeTransactionCardMaskedNumber;
    }

    /**
     * @return mixed
     */
    public function getBraintreeTransactionCustomerLocation()
    {
        return $this->braintreeTransactionCustomerLocation;
    }

    /**
     * @param mixed $braintreeTransactionCustomerLocation
     */
    public function setBraintreeTransactionCustomerLocation($braintreeTransactionCustomerLocation)
    {
        $this->braintreeTransactionCustomerLocation = $braintreeTransactionCustomerLocation;
    }


    // add your own fields
}
