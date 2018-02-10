<?php

namespace App\Controller\Backend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Article;
use App\Form\ArticleType;


/**
 * Class ArticleController
 * @package App\Controller\Backend
 * @Route("/admin/article")
 */
class ArticleController extends Controller
{
    /**
     * @Route("", name="article_list")
     */
    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository(Article::class)->findAll();

        return $this->render('backend/article/list.html.twig', [
            'articles'   => $articles
        ]);
    }

    /**
     * @Route("/new", name="article_new")
     */
    public function newAction(Request $request, FileUploader $fileUploader)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $file = $article->getPrincipalCover();
            if ($file){
                $fileName = $fileUploader->uploadArticleCover($file);
                $article->setPrincipalCover($fileName);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            $this->addFlash('success','Article created !');

            return $this->redirectToRoute('article_list');
        }

        return $this->render('backend/article/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

}
