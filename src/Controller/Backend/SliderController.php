<?php

namespace App\Controller\Backend;

use App\Entity\Slider;
use App\Form\SliderType;
use App\Service\FileUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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

        $slideName = $slide->getSlideName();
        $videoName = $slide->getSlideVideoName();
        if (!$slide) {

            throw $this->createNotFoundException(
                'No slide found for id '.$id
            );

        }

        $form = $this->createForm(SliderType::class, $slide);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid() && !$form->isEmpty()){
            if (is_null($request->files->get('slider')['slideName']) && is_null($request->files->get('slider')['slideVideoName']))
            {
                $slide->setSlideVideoName($videoName);
                $slide->setSlideName($slideName);
            }


            $file = $request->files->get('slider')['slideName'];
            if ($file instanceof UploadedFile){
                $dir = 'uploads/Slides/images/'.$slideName;
                unlink($dir);
                $fileName = $fileUploader->uploadSlider($file);
                $slide->setSlideName($fileName);
            }

            $video = $request->files->get('slider')['slideVideoName'];
            if ($video){
                $dir = 'uploads/Slides/videos/'.$videoName;
                unlink($dir);
                $videoName = $fileUploader->uploadSliderVideo($video);
                $slide->setSlideVideoName($videoName);
            }
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

    /**
     * @Route("delete/{id}", name="slider_delete")
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $slide =  $em->getRepository(Slider::class)->find($id);

        if (!$slide) {

            throw $this->createNotFoundException(
                'No slide found for id '.$id
            );

        }

        if ($slide->getSlideStyle() == 'video'){
            $dir = 'uploads/Slides/videos/';
            unlink($dir.$slide->getSlideVideoName());
        }else {
            $dir = 'uploads/Slides/images/';
            unlink($dir.$slide->getSlideName());
        }

        $em->remove($slide);
        $em->flush();

        $this->addFlash('danger','Slide Deleted !');

        return $this->redirectToRoute('slider_list');
    }
}
