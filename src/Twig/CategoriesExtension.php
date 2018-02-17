<?php
namespace App\Twig;

use App\Entity\Category;
use Doctrine\ORM\EntityManager;
use Twig\Extension\AbstractExtension;
use Twig_Function;


class CategoriesExtension extends AbstractExtension
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getFunctions()
    {
        return [
            new Twig_Function('getCategories',     [$this, 'getCategories'])
        ];
    }

    public function getCategories()
    {
        $categories = $this->em->getRepository(Category::class)->getPublicatedCategories();

        return $categories;
    }
}