<?php

namespace App\Controller\Backend;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Service\FileUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
}
