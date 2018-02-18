<?php
namespace App\Twig;

use App\Entity\Cart;
use App\Entity\Category;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Twig\Extension\AbstractExtension;
use Twig_Function;


class CategoriesExtension extends AbstractExtension
{
    protected $em;
    protected $token;

    public function __construct(EntityManager $em, TokenStorageInterface $tokenStorage)
    {
        $this->em = $em;
        $this->token = $tokenStorage;
    }

    public function getFunctions()
    {
        return [
            new Twig_Function('getCategories',     [$this, 'getCategories']),
            new Twig_Function('getUserCart',     [$this, 'getUserCart'])
        ];
    }

    public function getCategories()
    {
        $categories = $this->em->getRepository(Category::class)->getPublicatedCategories();

        return $categories;
    }

    public function getUserCart()
    {
        $user = $this->token->getToken()->getUser();
        $cart = $this->em->getRepository(Cart::class)->getUserCart($user);

        return $cart;
    }
}