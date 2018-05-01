<?php


namespace App\Controller\Frontend;


use App\Entity\Collection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class CollectionController extends Controller
{
    /**
     * @Route("/collection/{collectionId}/{page}", name="collection_index", requirements={"page"="\d+"})
     */
    public function index($collectionId, $page = 1, $nbArticles = 4){

        $em = $this->getDoctrine()->getManager();
        $selectedCollection = $em->getRepository(Collection::class)->find($collectionId);

        if (!$selectedCollection){
            throw new NotFoundHttpException('Collection doesn\'t  exists');
        }

        $articles = $em->getRepository(Collection::class)
            ->getPaginatedArticles($page, $selectedCollection->getCollectionId(), $nbArticles)
        ;


        return $this->render('frontend/collection/index.html.twig', [
            'collection'  =>  $selectedCollection,
            'articles' => $articles,
        ]);
    }
}