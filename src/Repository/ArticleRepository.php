<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function getEightNewArticles()
    {
        $query = $this->createQueryBuilder('a')
            ->orderBy('a.createdAt','DESC')
            ->setMaxResults(8)
            ->getQuery()
            ->getResult()
        ;

        return $query;
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('a')
            ->where('a.something = :value')->setParameter('value', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
