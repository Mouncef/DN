<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="tbl_category")
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", name="category_id")
     */
    private $categoryId;

    /**
     * @ORM\Column(type="string", name="cover", nullable=true)
     * @Assert\File()
     */
    private $cover;

    /**
     * @ORM\Column(type="string", name="caption", nullable=true)
     */
    private $caption;

    /**
     * @ORM\Column(type="string", name="name", unique=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", name="category_style")
     */
    private $categoryStyle;

    /**
     * @ORM\Column(type="datetime", name="created_at")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", name="updated_at", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="boolean", name="is_publicated")
     */
    private $isPublicated;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="category")
     */
    private $articles;


    public function __construct()
    {
        $this->createdAt = new \DateTime('now');
        $this->isPublicated = false;
        $this->articles = new ArrayCollection();

    }

    /**
     * @return Collection|Article[]
     */
    public function getProducts()
    {
        return $this->articles;
    }


    public function getCategoryId()
    {
        return $this->categoryId;
    }


    public function getCover()
    {
        return $this->cover;
    }


    public function setCover($cover)
    {
        $this->cover = $cover;
    }


    public function getCaption()
    {
        return $this->caption;
    }


    public function setCaption($caption)
    {
        $this->caption = $caption;
    }


    public function getName()
    {
        return $this->name;
    }


    public function setName($name)
    {
        $this->name = $name;
    }


    public function getCreatedAt()
    {
        return $this->createdAt;
    }


    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }


    public function getIsPublicated()
    {
        return $this->isPublicated;
    }

    public function setIsPublicated($isPublicated)
    {
        $this->isPublicated = $isPublicated;
    }

    public function getCategoryStyle()
    {
        return $this->categoryStyle;
    }

    public function setCategoryStyle($categoryStyle)
    {
        $this->categoryStyle = $categoryStyle;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    public function addArticle(Article $article)
    {
        if ($this->articles->contains($article)) {
            return;
        }

        $this->articles[] = $article;
        // set the *owning* side!
        $article->setCategory($this);
    }

    public function removeArticle(Article $article)
    {
        $this->articles->removeElement($article);
        // set the owning side to null
        $article->setCategory(null);
    }

}
