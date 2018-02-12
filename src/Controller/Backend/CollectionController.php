<?php

namespace App\Controller\Backend;

use App\Entity\Collection;
use App\Form\CollectionType;
use App\Service\FileUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CollectionController
 * @package App\Controller\Backend
 * @Route("/admin/collection")
 */
class CollectionController extends Controller
{
    /**
     * @Route("", name="collection_list")
     */
    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $collections = $em->getRepository(Collection::class)->findAll();

        return $this->render('backend/collection/list.html.twig', [
            'collections'   => $collections
        ]);
    }

    /**
     * @Route("/new", name="collection_new")
     */
    public function newAction(Request $request, FileUploader $fileUploader)
    {
        $collection = new Collection();
        $form = $this->createForm(CollectionType::class, $collection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $file = $collection->getCover();
            if ($file){
                $fileName = $fileUploader->uploadCollectionCover($file);
                $collection->setCover($fileName);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($collection);
            $em->flush();

            $this->addFlash('success','Collection created !');

            return $this->redirectToRoute('collection_list');
        }

        return $this->render('backend/collection/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
