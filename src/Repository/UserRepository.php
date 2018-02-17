<?php

namespace App\Repository;

use App\Entity\Profil;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

class UserRepository extends EntityRepository implements UserLoaderInterface
{
    public function loadUserByUsername($username)
    {
        return $this->createQueryBuilder('u')
            ->where('u.username = :username OR u.email = :email')
            ->setParameters(['username'=> $username, 'email' => $username])
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getMembers(Profil $profil)
    {
        $query = $this->createQueryBuilder('u')
            ->where('u.profil = :profil')
            ->andWhere('u.isActive = 1')
            ->setParameter('profil',$profil)
            ->getQuery()
            ->getResult()
        ;

        return $query;
    }

    /*public function getMembers()
    {
        return $this->createQueryBuilder('u')

            ->getQuery()
            ->getResult()
        ;
    }*/
}
