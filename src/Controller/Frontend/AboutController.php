<?php

namespace App\Controller\Frontend;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class AboutController extends Controller
{
    /**
     * @Route("/OurStory", name="about_index")
     */
    public function index()
    {

        return $this->render('frontend/about/index.html.twig');
    }
}