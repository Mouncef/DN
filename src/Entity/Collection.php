<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Table(name="tbl_collection")
 * @ORM\Entity(repositoryClass="App\Repository\CollectionRepository")
 */
class Collection
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", name="collection_id")
     */
    private $collectionId;

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
     * @ORM\ManyToMany(targetEntity="App\Entity\Article", inversedBy="collections")
     * @ORM\JoinTable(name="lnk_article_collection",
     * joinColumns={
     *     @ORM\JoinColumn(name="collection_id", referencedColumnName="collection_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="article_id", referencedColumnName="article_id")
     *   }
     * )
     */
    private $articles;


    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->createdAt = new \DateTime('now');
        $this->isPublicated = false;
    }

    // Notez le singulier, on ajoute une seule catégorie à la fois
    public function addArticle(Article $article)
    {
        // Ici, on utilise l'ArrayCollection vraiment comme un tableau
        $this->articles[] = $article;

        return $this;
    }

    public function removeArticle(Article $article)
    {
        // Ici on utilise une méthode de l'ArrayCollection, pour supprimer la catégorie en argument
        $this->articles->removeElement($article);
    }

    // Notez le pluriel, on récupère une liste de catégories ici !
    public function getArticles()
    {
        return $this->articles;
    }

    public function getCollectionId()
    {
        return $this->collectionId;
    }

    /**
     * @return mixed
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * @param mixed $cover
     */
    public function setCover($cover)
    {
        $this->cover = $cover;
    }

    /**
     * @return mixed
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * @param mixed $caption
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return mixed
     */
    public function getIsPublicated()
    {
        return $this->isPublicated;
    }

    /**
     * @param mixed $isPublicated
     */
    public function setIsPublicated($isPublicated)
    {
        $this->isPublicated = $isPublicated;
    }


}
