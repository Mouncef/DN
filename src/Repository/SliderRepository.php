<?php

namespace App\Repository;

use App\Entity\Slider;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class SliderRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Slider::class);
    }

    public function getPublicatedSlides()
    {
        $query = $this->_em->getRepository(Slider::class)->createQueryBuilder('s')
            ->where('s.isPublicated = 1')
            ->orderBy('s.createdAt','ASC')
            ->setMaxResults(5)
            ->getQuery()->getResult()
        ;

        return $query;
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('s')
            ->where('s.something = :value')->setParameter('value', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
