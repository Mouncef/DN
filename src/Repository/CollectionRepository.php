<?php

namespace App\Repository;

use App\Entity\Collection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bridge\Doctrine\RegistryInterface;

class CollectionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Collection::class);
    }

    public function getPublicatedCollections()
    {
        $query = $this->createQueryBuilder('c')
            ->where('c.isPublicated = 1')
            ->orderBy('c.createdAt','DESC')
            ->getQuery()->getResult()
        ;

        return $query;
    }

    public function getPaginatedArticles(int $page = 1, int $id, int $nbArticles) : Pagerfanta
    {

        $query = $this->_em
            ->createQuery('
                SELECT a 
                FROM App\\Entity\\Article a  
                INNER JOIN App\\Entity\\LnkArticleCollection cc 
                WITH a.articleId = cc.articleId 
                WHERE cc.collectionId = :id
                ORDER BY a.createdAt DESC
            ')
            ->setParameter('id',$id)
        ;


        return $this->createPaginator($query, $page, $nbArticles);

    }

    private function createPaginator(Query $query, int $page, $nbArticles): Pagerfanta
    {
        $paginator = new Pagerfanta(new DoctrineORMAdapter($query));
        $paginator->setMaxPerPage($nbArticles);
        $paginator->setCurrentPage($page);

        return $paginator;
    }
}
