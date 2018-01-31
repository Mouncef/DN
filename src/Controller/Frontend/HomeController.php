<?php

namespace App\Controller\Frontend;

use App\Entity\Slider;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(){

        $em = $this->getDoctrine()->getManager();

        $sliders = $em->getRepository(Slider::class)->getPublicatedSlides();

        return $this->render('frontend/index.html.twig', [
            'sliders' => $sliders
        ]);
    }

}