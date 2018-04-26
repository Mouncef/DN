<?php
/**
 * Created by PhpStorm.
 * User: Mouncef
 * Date: 22/04/2018
 * Time: 18:29
 */

namespace App\Entity;

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
}