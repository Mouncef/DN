<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CartRepository")
 * @ORM\Table(name="tbl_cart")
 */
class Cart
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", name="cart_id")
     */
    private $cartId;

    /**
     * @ORM\Column(type="datetime", name="created_at")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", name="updated_at", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime", name="checked_at", nullable=true)
     */
    private $checkedAt;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Article", inversedBy="carts")
     * @ORM\JoinTable(name="lnk_article_cart",
     * joinColumns={
     *     @ORM\JoinColumn(name="cart_id", referencedColumnName="cart_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="article_id", referencedColumnName="article_id")
     *   }
     * )
     */
    private $articles;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="carts")
     * @ORM\JoinColumn(name="user", referencedColumnName="user_id")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Order", mappedBy="cart")
     */
    private $orders;

    // add your own fields

    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->orders = new ArrayCollection();
        $this->createdAt = new \DateTime('now');
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

    public function getUser()
    {
        return $this->user;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function getCartId()
    {
        return $this->cartId;
    }

    public function getCheckedAt()
    {
        return $this->checkedAt;
    }

    public function setCheckedAt($checkedAt)
    {
        $this->checkedAt = $checkedAt;
    }

    public function getTotal()
    {

        $total=0;$totalProducts = 0;

        foreach ($this->articles as $article){
            /** @var Article $article */
            $totalProducts = $total + $article->getPrice();
            $total = $totalProducts;
        }

        return number_format($totalProducts, '2','.','');
    }

    public function getTvaPrice($tva){
        return round($this->getTotal() * $tva * 100)/100;
    }

    public function getUsTotal(){

        $total = $this->getTotal();
        $usTotal = $total * 3.32215;

        return number_format($usTotal, '2', '.', '');
    }
}
