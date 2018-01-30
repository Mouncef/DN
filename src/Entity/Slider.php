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
     * @ORM\Column(type="string", name="slide_name", nullable=true)
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

    /**
     * @ORM\Column(type="string", name="slide_style")
     */
    private $slideStyle;

    /**
     * @ORM\Column(type="string", name="slide_video_name", nullable=true)
     * @Assert\File()
     */
    private $slideVideoName;

    /**
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @ORM\Column(name="is_publicated", type="boolean")
     */
    private $isPublicated;

    public function __construct()
    {
        $this->createdAt = new \DateTime('now');
        $this->isPublicated = false;
    }

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


    public function getCaption1()
    {
        return $this->caption1;
    }


    public function setCaption1($caption1)
    {
        $this->caption1 = $caption1;
    }


    public function getCaption2()
    {
        return $this->caption2;
    }

    public function setCaption2($caption2)
    {
        $this->caption2 = $caption2;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;
    }

    public function getSlideStyle()
    {
        return $this->slideStyle;
    }

    public function setSlideStyle($slideStyle)
    {
        $this->slideStyle = $slideStyle;
    }

    public function getSlideVideoName()
    {
        return $this->slideVideoName;
    }

    public function setSlideVideoName($slideVideoName)
    {
        $this->slideVideoName = $slideVideoName;
    }

    public function getisPublicated()
    {
        return $this->isPublicated;
    }

    public function setIsPublicated($isPublicated)
    {
        $this->isPublicated = $isPublicated;
    }



    // add your own fields
}
