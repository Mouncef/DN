<?php

namespace App\Controller\Backend;

use App\Entity\Slider;
use App\Form\SliderType;
use App\Service\FileUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SliderController extends Controller
{
    /**
     * @Route("/slider/new", name="slider_new")
     */
    public function index(Request $request, FileUploader $fileUploader)
    {
        $slider = new Slider();
        $form = $this->createForm(SliderType::class, $slider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $file = $slider->getSlideName();

            $fileName = $fileUploader->uploadSlider($file);

            $slider->setSlideName($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($slider);
            $em->flush();

            $this->addFlash('success','Slide Importé avec succés !');

            return $this->redirect($this->generateUrl('slider_new'));
        }

        return $this->render('backend/slider/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}