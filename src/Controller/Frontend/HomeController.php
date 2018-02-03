<?php

namespace App\Controller\Frontend;

use App\Entity\Slider;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class HomeController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(Request $request){

        $em = $this->getDoctrine()->getManager();

        $sliders = $em->getRepository(Slider::class)->getPublicatedSlides();

//        var_dump($request->attributes->get('_route'));die;

        return $this->render('frontend/index.html.twig', [
            'sliders' => $sliders
        ]);
    }

}