<?php

namespace App\Controller\Backend;

use App\Entity\Slider;
use App\Form\SliderType;
use App\Service\FileUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SliderController
 * @package App\Controller\Backend
 * @Route("/admin/slider")
 */
class SliderController extends Controller
{
    /**
     * @Route("", name="slider_list")
     */
    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $sliders = $em->getRepository(Slider::class)->findAll();

        return $this->render('backend/slider/list.html.twig', [
            'sliders'   => $sliders
        ]);
    }

    /**
     * @Route("/new", name="slider_new")
     */
    public function newAction(Request $request, FileUploader $fileUploader)
    {
        $slider = new Slider();
        $form = $this->createForm(SliderType::class, $slider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $file = $slider->getSlideName();
            if ($file){
                $fileName = $fileUploader->uploadSlider($file);
                $slider->setSlideName($fileName);
            }

            $video = $slider->getSlideVideoName();
            if ($video){
                $videoName = $fileUploader->uploadSliderVideo($video);
                $slider->setSlideVideoName($videoName);
            }


            $em = $this->getDoctrine()->getManager();
            $em->persist($slider);
            $em->flush();

            $this->addFlash('success','Slide Importé avec succés !');

            return $this->redirectToRoute('slider_list');
        }

        return $this->render('backend/slider/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/edit/{id}", name="slider_edit", requirements={"id": "\d+"})
     */
    public function edit(Request $request, FileUploader $fileUploader, $id){

        $em = $this->getDoctrine()->getManager();
        $slide =  $em->getRepository(Slider::class)->find($id);

        if (!$slide) {

            throw $this->createNotFoundException(
                'No slide found for id '.$id
            );

        }

        $form = $this->createFormBuilder($slide)
            ->add('slideName', FileType::class, [
                'data_class' => null,
                'required'  => false
            ])
            ->add('caption1', null, ['required'  => false])
            ->add('caption2', null, ['required'  => false])
            ->getForm()
        ;
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid() && !$form->isEmpty()){

            $file = $slide->getSlideName();

            $fileName = $fileUploader->uploadSlider($file);

            $slide->setSlideName($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash('success','Slide Modifié avec succés !');

            return $this->redirectToRoute('slider_list');
        }

        return $this->render('backend/slider/edit.html.twig', array(
            'form' => $form->createView(),
            'slide' =>  $slide
        ));

    }

}
