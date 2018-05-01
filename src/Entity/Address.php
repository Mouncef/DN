<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\AddressRepository")
 * @ORM\Table(name="tbl_address")
 */
class Address
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", name="address_id")
     */
    private $addressId;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(name="adress_text", type="text")
     */
    private $adressText;

    /**
     * @ORM\Column(name="city", type="string", length=150, nullable=true)
     */
    private $city;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(name="zip_code", type="string", length=10)
     */
    private $zipCode;

    /**
     * @ORM\Column(name="country", type="string", length=150, nullable=true)
     */
    private $country;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(name="phone", type="string", length=15)
     */
    private $phone;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Order", mappedBy="address")
     */
    private $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    public function getAdressText()
    {
        return $this->adressText;
    }

    public function setAdressText($adressText)
    {
        $this->adressText = $adressText;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function getZipCode()
    {
        return $this->zipCode;
    }

    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setCountry($country)
    {
        $this->country = $country;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function getAddressId()
    {
        return $this->addressId;
    }


}
