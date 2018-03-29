<?php
/**
 * Created by PhpStorm.
 * User: Mouncef
 * Date: 19/03/2018
 * Time: 21:15
 */

namespace App\Controller\Frontend;


use App\Entity\Category;
use App\Entity\Order;
use App\Entity\User;
use App\Utils\Constant;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Zend\Code\Scanner\Util;

class CategoryController extends Controller
{
    /**
     * @Route("/category/{category}/{page}", name="category_index", requirements={"page"="\d+"})
     */
    public function index($category, $page = 1, $nbArticles = 4){

        $em = $this->getDoctrine()->getManager();
        $selectedCategory = $em->getRepository(Category::class)->findOneBy([
            'name' => $category
        ]);

        if (!$selectedCategory){
            throw new NotFoundHttpException('Category doesn\'t  exists');
        }

        $articles = $em->getRepository(Category::class)
            ->getPaginatedArticles($page, $selectedCategory->getCategoryId(), $nbArticles)
        ;

        return $this->render('frontend/category/index.html.twig', [
            'category'  =>  $selectedCategory,
            'articles' => $articles,
        ]);
    }
}