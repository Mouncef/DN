<?php

namespace App\Controller\Frontend;

use App\Entity\Article;
use App\Entity\Cart;
use App\Entity\Category;
use App\Entity\Collection;
use App\Entity\Slider;
use App\Entity\Subscribers;
use App\Repository\CollectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class HomeController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param Request $request
     */
    public function index(){

        $em = $this->getDoctrine()->getManager();

        $sliders = $em->getRepository(Slider::class)->getPublicatedSlides();
        $categories = $em->getRepository(Category::class)->getPublicatedCategories();
        $collections = $em->getRepository(Collection::class)->getPublicatedCollections();

        $newArticles = $em->getRepository(Article::class)->getEightNewArticles();

        return $this->render('frontend/index.html.twig', [
            'sliders' => $sliders,
            'categories' => $categories,
            'collections' => $collections,
            'newArticles' => $newArticles
        ]);
    }

    /**
     * @Route("/Subscribe", name="subscribe")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function subscribe(Request $request)
    {
        $email = $request->get('email');

        $em = $this->getDoctrine()->getManager();
        $subscribers = $em->getRepository(Subscribers::class)->findAll();

        foreach ($subscribers as $subscriber)
        {
            $emailDB = $subscriber->getEmail();
            if ($email === $emailDB){
                throw $this->createAccessDeniedException(
                    'This email "'. $email .'" already exists in our database'
                );
            }
        }

        $subscriber = new Subscribers();
        $subscriber->setEmail($email);
        $em->persist($subscriber);
        $em->flush();
        $this->addFlash('success','Welcome in our subscribers database !');

        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/AddArticleToCart/{id}", name="add_article_to_cart")
     */
    public function addArticleToCart($id)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository(Article::class)->find($id);
        $user = $this->getUser();
        $cart = $em->getRepository(Cart::class)->getUserCart($user);

        if ($cart) {
            $cart->addArticle($article);
        }else {
            $cart = new Cart();
            $cart->setUser($user);
            $cart->addArticle($article);
        }

        $em->persist($cart);
        $em->flush();

        $this->addFlash('success','Article added to cart');

        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/RemoveArticleFromCart/{id}", name="remove_article_from_cart")
     */
    public function removeArticleFromCart($id)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository(Article::class)->find($id);
        $user = $this->getUser();
        $cart = $em->getRepository(Cart::class)->getUserCart($user);

        if ($cart) {
            if (count($cart->getArticles()) == 1){
            $em->remove($cart);
            } elseif (count($cart->getArticles()) > 1 )
            $cart->removeArticle($article);
        }
        $em->flush();

        $this->addFlash('success','Article removed from cart');

        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/search", name="search_article", options={"expose"=true})
     */
    public function searchArticle(Request $request) {

        $phrase = $request->get('_search');

        $em = $this->getDoctrine()->getManager();

        $pLike = '%'.$phrase.'%';

        $articles = $em->getRepository(Article::class)->createQueryBuilder('a')
            ->where('a.name LIKE :phrase')
            ->setParameter('phrase', $pLike)
            ->getQuery()
            ->getResult()
        ;


        if (empty($phrase) || empty($articles)){
            $html = 'frontend/search/404.html.twig';
        } else {
            $html = 'frontend/search/result.html.twig';
        }




        return $this->render($html, [
            'articles'  =>  $articles
        ]);
    }
}