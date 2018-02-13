<?php

namespace App\Controller\Frontend;

use App\Entity\Category;
use App\Entity\Slider;
use App\Entity\Subscribers;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class HomeController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request){

        $em = $this->getDoctrine()->getManager();

        $sliders = $em->getRepository(Slider::class)->getPublicatedSlides();
        $categories = $em->getRepository(Category::class)->getPublicatedCategories();

//        var_dump($request->attributes->get('_route'));die;

        return $this->render('frontend/index.html.twig', [
            'sliders' => $sliders,
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/Subscribe", name="subscribe")
     * @param Request $request
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