<?php

namespace App\Controller\Backend;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Service\FileUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CategoryController
 * @package App\Controller\Backend
 * @Route("/admin/category")
 */
class CategoryController extends Controller
{
    /**
     * @Route("", name="category_list")
     */
    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository(Category::class)->findAll();

        return $this->render('backend/category/list.html.twig', [
            'categories'   => $categories
        ]);
    }

    /**
     * @Route("/new", name="category_new")
     */
    public function newAction(Request $request, FileUploader $fileUploader)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $file = $category->getCover();
            if ($file){
                $fileName = $fileUploader->uploadCategoryCover($file);
                $category->setCover($fileName);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            $this->addFlash('success','Category created !');

            return $this->redirectToRoute('category_list');
        }

        return $this->render('backend/category/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/edit/{id}", name="category_edit", requirements={"id": "\d+"})
     */
    public function edit(Request $request, FileUploader $fileUploader, $id){

        $em = $this->getDoctrine()->getManager();
        $category =  $em->getRepository(Category::class)->find($id);

        $cover = $category->getCover();

        if (!$category) {

            throw $this->createNotFoundException(
                'No category found for id '.$id
            );

        }

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid() && !$form->isEmpty()){
            if (is_null($request->files->get('category')['cover']))
            {
                $category->setCover($cover);
            }


            $file = $request->files->get('category')['cover'];
            if ($file instanceof UploadedFile){
                $dir = 'uploads/Categories/images/'.$cover;
                unlink($dir);
                $fileName = $fileUploader->uploadCategoryCover($file);
                $category->setCover($fileName);
            }

            $category->setUpdatedAt(new \DateTime('now'));

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash('success','Category Edited !');

            return $this->redirectToRoute('category_list');
        }

        return $this->render('backend/category/edit.html.twig', array(
            'form' => $form->createView(),
            'category' =>  $category
        ));

    }

    /**
     * @Route("publish/{id}", name="category_publish")
     */
    public function publish($id)
    {
        $em = $this->getDoctrine()->getManager();
        $category =  $em->getRepository(Category::class)->find($id);

        if (!$category) {

            throw $this->createNotFoundException(
                'No category found for id '.$id
            );

        }

        $category->setIsPublicated(true);

        $em->persist($category);
        $em->flush();

        $this->addFlash('success','Category Published !');

        return $this->redirectToRoute('category_list');
    }

    /**
     * @Route("unpublish/{id}", name="category_unpublish")
     */
    public function unpublish($id)
    {
        $em = $this->getDoctrine()->getManager();
        $category =  $em->getRepository(Category::class)->find($id);

        if (!$category) {

            throw $this->createNotFoundException(
                'No category found for id '.$id
            );

        }

        $category->setIsPublicated(false);

        $em->persist($category);
        $em->flush();

        $this->addFlash('warning','Category Unpublished !');

        return $this->redirectToRoute('category_list');
    }

    /**
     * @Route("delete/{id}", name="category_delete")
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $category =  $em->getRepository(Category::class)->find($id);

        if (!$category) {

            throw $this->createNotFoundException(
                'No category found for id '.$id
            );

        }

        $dir = 'uploads/Categories/images/';
        unlink($dir.$category->getCover());


        $em->remove($category);
        $em->flush();

        $this->addFlash('danger','Category Deleted !');

        return $this->redirectToRoute('category_list');
    }

}
