<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="tbl_payment_detail")
 * @ORM\Entity
 */
class PaymentDetails
{
    /**
     * @ORM\Column(name="payement_detail_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @var integer $id
     */
    protected $payementDetailId;
}