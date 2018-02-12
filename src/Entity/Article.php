<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Table(name="tbl_article")
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", name="article_id")
     */
    private $articleId;

    /**
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", name="principal_cover", nullable=true)
     * @Assert\File()
     */
    private $principalCover;

    /**
     * @ORM\Column(type="string", name="cover_second", nullable=true)
     * @Assert\File()
     */
    private $coverSecond;

    /**
     * @ORM\Column(type="string", name="cover_third", nullable=true)
     * @Assert\File()
     */
    private $coverThird;

    /**
     * @ORM\Column(type="string", name="cover_fourth", nullable=true)
     * @Assert\File()
     */
    private $coverFourth;

    /**
     * @ORM\Column(type="boolean", name="is_published")
     */
    private $isPublished;

    /**
     * @ORM\Column(type="boolean", name="is_available")
     */
    private $isAvailable;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="articles")
     * @ORM\JoinColumn(name="category", referencedColumnName="category_id")
     */
    private $category;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Collection", mappedBy="articles")
     * @ORM\JoinTable(name="lnk_article_collection",
     *     joinColumns={
     *     @ORM\JoinColumn(name="article_id", referencedColumnName="article_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="collection_id", referencedColumnName="collection_id")
     *   }
     * )
     */
    private $collections;

    public function __construct()
    {
        $this->createdAt = new \Datetime('now');
        $this->isPublished = false;
        $this->collections = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getArticleId()
    {
        return $this->articleId;
    }


    public function getName()
    {
        return $this->name;
    }


    public function setName($name)
    {
        $this->name = $name;
    }


    public function getPrice()
    {
        return $this->price;
    }


    public function setPrice($price)
    {
        $this->price = $price;
    }


    public function getDescription()
    {
        return $this->description;
    }


    public function setDescription($description)
    {
        $this->description = $description;
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


    public function getPrincipalCover()
    {
        return $this->principalCover;
    }


    public function setPrincipalCover($principalCover)
    {
        $this->principalCover = $principalCover;
    }


    public function getCoverSecond()
    {
        return $this->coverSecond;
    }


    public function setCoverSecond($coverSecond)
    {
        $this->coverSecond = $coverSecond;
    }


    public function getCoverThird()
    {
        return $this->coverThird;
    }


    public function setCoverThird($coverThird)
    {
        $this->coverThird = $coverThird;
    }


    public function getCoverFourth()
    {
        return $this->coverFourth;
    }


    public function setCoverFourth($coverFourth)
    {
        $this->coverFourth = $coverFourth;
    }


    public function getIsPublished()
    {
        return $this->isPublished;
    }


    public function setIsPublished($isPublished)
    {
        $this->isPublished = $isPublished;
    }

    public function getIsAvailable()
    {
        return $this->isAvailable;
    }


    public function setIsAvailable($isAvailable)
    {
        $this->isAvailable = $isAvailable;
    }


    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory(Category $category)
    {
        $this->category = $category;
    }

    public function getCollections()
    {
        return $this->collections;
    }


}
