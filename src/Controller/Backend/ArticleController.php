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

            $file2 = $article->getCoverSecond();
            if ($file2){
                $fileName2 = $fileUploader->uploadArticleSecondCover($file2);
                $article->setCoverSecond($fileName2);
            }

            $file3 = $article->getCoverThird();
            if ($file3){
                $fileName3 = $fileUploader->uploadArticleThirdCover($file3);
                $article->setCoverThird($fileName3);
            }

            $file4 = $article->getCoverFourth();
            if ($file4){
                $fileName4 = $fileUploader->uploadArticleFourthCover($file4);
                $article->setCoverFourth($fileName4);
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

    /**
     * @Route("/edit/{id}", name="article_edit", requirements={"id": "\d+"})
     */
    public function edit(Request $request, FileUploader $fileUploader, $id){

        $em = $this->getDoctrine()->getManager();
        $article =  $em->getRepository(Article::class)->find($id);

        $articleCover = $article->getPrincipalCover();
        $articleSecondCover = $article->getCoverSecond();
        $articleThirdCover = $article->getCoverThird();
        $articleFourthCover = $article->getCoverFourth();

        if (!$article) {

            throw $this->createNotFoundException(
                'No slide found for id '.$id
            );

        }

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid() && !$form->isEmpty()){
            if (is_null($request->files->get('article')['principalCover']))
            {
                $article->setPrincipalCover($articleCover);
            }else {
                $file = $request->files->get('article')['principalCover'];
                if ($file instanceof UploadedFile){
                    $dir = 'uploads/Articles/images/'.$articleCover;
                    if ($articleCover !== null && file_exists($dir)){
                        unlink($dir);
                    }
                    $fileName = $fileUploader->uploadArticleCover($file);
                    $article->setPrincipalCover($fileName);
                }
            }
            if (is_null($request->files->get('article')['coverSecond'])){
                $article->setCoverSecond($articleSecondCover);
            }else {
                $file2 = $request->files->get('article')['coverSecond'];
                if ($file2 instanceof UploadedFile){
                    $dir = 'uploads/Articles/images/Second/'.$articleSecondCover;
                    if ($articleSecondCover !== null){
                        unlink($dir);
                    }
                    $fileName2 = $fileUploader->uploadArticleSecondCover($file2);
                    $article->setCoverSecond($fileName2);
                }
            }
            if (is_null($request->files->get('article')['coverThird'])){
                $article->setCoverThird($articleThirdCover);
            }else {
                $file3 = $request->files->get('article')['coverThird'];
                if ($file3 instanceof UploadedFile){
                    $dir = 'uploads/Articles/images/Third/'.$articleThirdCover;
                    if ($articleThirdCover !== null){
                        unlink($dir);
                    }
                    $fileName3 = $fileUploader->uploadArticleThirdCover($file3);
                    $article->setCoverThird($fileName3);
                }
            }
            if (is_null($request->files->get('article')['coverFourth'])){
                $article->setCoverFourth($articleFourthCover);
            }else {
                $file4 = $request->files->get('article')['coverFourth'];
                if ($file4 instanceof UploadedFile){
                    $dir = 'uploads/Articles/images/Fourth/'.$articleFourthCover;
                    if ($articleFourthCover !== null){
                        unlink($dir);
                    }
                    $fileName4 = $fileUploader->uploadArticleFourthCover($file4);
                    $article->setCoverFourth($fileName4);
                }
            }

            $article->setUpdatedAt(new \DateTime('now'));

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash('success','Article Modified !');

            return $this->redirectToRoute('article_list');
        }

        return $this->render('backend/article/edit.html.twig', array(
            'form' => $form->createView(),
            'article' =>  $article
        ));

    }

    /**
     * @Route("delete/{id}", name="article_delete")
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $article =  $em->getRepository(Article::class)->find($id);

        if (!$article) {

            throw $this->createNotFoundException(
                'No article found for id '.$id
            );

        }


        $dirCover = 'uploads/Articles/images/';
        if (file_exists($dirCover.$article->getPrincipalCover()) && $article->getPrincipalCover() !== null) {
            unlink($dirCover.$article->getPrincipalCover());
        }

        $dirSecondCover = 'uploads/Articles/images/Second/';
        if (file_exists($dirSecondCover.$article->getCoverSecond()) && $article->getCoverSecond() !== null) {
            unlink($dirSecondCover.$article->getCoverSecond());
        }

        $dirThirdCover = 'uploads/Articles/images/Third/';
        if (file_exists($dirThirdCover.$article->getCoverThird()) && $article->getCoverThird() !== null) {
            unlink($dirThirdCover.$article->getCoverThird());
        }

        $dirFourthCover = 'uploads/Articles/images/Fourth/';
        if (file_exists($dirFourthCover.$article->getCoverFourth()) && $article->getCoverFourth() !== null) {
            unlink($dirFourthCover.$article->getCoverFourth());
        }

        $em->remove($article);
        $em->flush();

        $this->addFlash('danger','Article Deleted !');

        return $this->redirectToRoute('article_list');
    }

    /**
     * @Route("publish/{id}", name="article_publish")
     */
    public function publish($id)
    {
        $em = $this->getDoctrine()->getManager();
        $article =  $em->getRepository(Article::class)->find($id);

        if (!$article) {

            throw $this->createNotFoundException(
                'No article found for id '.$id
            );

        }

        $article->setIsPublished(true);

        $em->persist($article);
        $em->flush();

        $this->addFlash('success','Article Published !');

        return $this->redirectToRoute('article_list');
    }

    /**
     * @Route("unpublish/{id}", name="article_unpublish")
     */
    public function unpublish($id)
    {
        $em = $this->getDoctrine()->getManager();
        $article =  $em->getRepository(Article::class)->find($id);

        if (!$article) {

            throw $this->createNotFoundException(
                'No article found for id '.$id
            );

        }

        $article->setIsPublished(false);

        $em->persist($article);
        $em->flush();

        $this->addFlash('warning','Article Unpublished !');

        return $this->redirectToRoute('article_list');
    }
}
