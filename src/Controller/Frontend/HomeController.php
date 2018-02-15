<?php

namespace App\Controller\Frontend;

use App\Entity\Article;
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

}