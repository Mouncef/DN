<?php

namespace App\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\TranslatorInterface;

class TranslationController extends Controller
{
    /**
     * @Route("/translation", name="translation")
     */
    public function index(TranslatorInterface $translator)
    {
        $translated = $translator->trans('Symfony is great');

        return new Response($translated);
    }

    /**
     * @Route("/translation2", name="translation2")
     */
    public function index2(TranslatorInterface $translator)
    {
        $name = 'Mouncef';
        $translated = $translator->trans('Hello '.$name);

        return $this->render('translation/index.html.twig', [
            'name'  =>  $name,
            'count' =>  3,
            'message'   =>  'test'
        ]);
    }

}
