<?php

namespace App\Repository;

use App\Entity\Article;
use App\Utils\Variables;
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
        $date = new Variables();

        $query = $this->createQueryBuilder('a')
            ->where('a.createdAt >= :date ')
            ->orderBy('a.createdAt','DESC')
            ->setParameter('date', $date->getDateMinus30Days())
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
