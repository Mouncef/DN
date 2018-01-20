<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="tbl_slider")
 * @ORM\Entity(repositoryClass="App\Repository\SliderRepository")
 */
class Slider
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", name="slider_id")
     */
    private $sliderId;

    /**
     * @ORM\Column(type="string", name="slide_name")
     * @Assert\NotBlank()
     * @Assert\File()
     */
    private $slideName;

    /**
     * @ORM\Column(type="string", name="caption_1")
     */
    private $caption1;

    /**
     * @ORM\Column(type="string", name="caption_2")
     */
    private $caption2;


    public function getSliderId()
    {
        return $this->sliderId;
    }


    public function getSlideName()
    {
        return $this->slideName;
    }


    public function setSlideName($slideName)
    {
        $this->slideName = $slideName;
    }

    /**
     * @return mixed
     */
    public function getCaption1()
    {
        return $this->caption1;
    }

    /**
     * @param mixed $caption1
     */
    public function setCaption1($caption1)
    {
        $this->caption1 = $caption1;
    }

    /**
     * @return mixed
     */
    public function getCaption2()
    {
        return $this->caption2;
    }

    /**
     * @param mixed $caption2
     */
    public function setCaption2($caption2)
    {
        $this->caption2 = $caption2;
    }



    // add your own fields
}
