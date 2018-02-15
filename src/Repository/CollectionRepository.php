<?php

namespace App\Repository;

use App\Entity\Collection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
}
