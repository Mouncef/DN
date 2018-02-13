<?php

namespace App\Controller\Backend;

use App\Entity\Collection;
use App\Form\CollectionType;
use App\Service\FileUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();

        $collections = $em->getRepository(Collection::class)->findAll();

        return $this->render('backend/collection/list.html.twig', [
            'collections'   => $collections
        ]);
    }

    /**
     * @Route("/new", name="collection_new")
     * @param Request $request
     * @param FileUploader $fileUploader
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
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

    /**
     * @Route("/edit/{id}", name="collection_edit", requirements={"id": "\d+"})
     * @param Request $request
     * @param FileUploader $fileUploader
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function edit(Request $request, FileUploader $fileUploader, $id){

        $em = $this->getDoctrine()->getManager();
        $collection =  $em->getRepository(Collection::class)->find($id);

        $cover = $collection->getCover();

        if (!$collection) {

            throw $this->createNotFoundException(
                'No collection found for id '.$id
            );

        }

        $form = $this->createForm(CollectionType::class, $collection);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid() && !$form->isEmpty()){
            if (is_null($request->files->get('collection')['cover']))
            {
                $collection->setCover($cover);
            }


            $file = $request->files->get('collection')['cover'];
            if ($file instanceof UploadedFile){
                $dir = 'uploads/Collections/images/'.$cover;
                unlink($dir);
                $fileName = $fileUploader->uploadCollectionCover($file);
                $collection->setCover($fileName);
            }

            $collection->setUpdatedAt(new \DateTime('now'));

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash('success','Collection Edited !');

            return $this->redirectToRoute('collection_list');
        }

        return $this->render('backend/collection/edit.html.twig', array(
            'form' => $form->createView(),
            'collection' =>  $collection
        ));

    }

    /**
     * @Route("publish/{id}", name="collection_publish")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function publish($id)
    {
        $em = $this->getDoctrine()->getManager();
        $collection =  $em->getRepository(Collection::class)->find($id);

        if (!$collection) {

            throw $this->createNotFoundException(
                'No collection found for id '.$id
            );

        }

        $collection->setIsPublicated(true);

        $em->persist($collection);
        $em->flush();

        $this->addFlash('success','Collection Published !');

        return $this->redirectToRoute('collection_list');
    }

    /**
     * @Route("unpublish/{id}", name="collection_unpublish")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function unpublish($id)
    {
        $em = $this->getDoctrine()->getManager();
        $collection =  $em->getRepository(Collection::class)->find($id);

        if (!$collection) {

            throw $this->createNotFoundException(
                'No collection found for id '.$id
            );

        }

        $collection->setIsPublicated(false);

        $em->persist($collection);
        $em->flush();

        $this->addFlash('warning','Collection Unpublished !');

        return $this->redirectToRoute('collection_list');
    }

    /**
     * @Route("delete/{id}", name="collection_delete")
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $collection =  $em->getRepository(Collection::class)->find($id);

        if (!$collection) {

            throw $this->createNotFoundException(
                'No collection found for id '.$id
            );

        }

        $dir = 'uploads/Collections/images/';
        unlink($dir.$collection->getCover());


        $em->remove($collection);
        $em->flush();

        $this->addFlash('danger','Collection Deleted !');

        return $this->redirectToRoute('collection_list');
    }
}
