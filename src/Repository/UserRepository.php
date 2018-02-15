<?php

namespace App\Repository;

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

    /*public function getMembers()
    {
        return $this->createQueryBuilder('u')

            ->getQuery()
            ->getResult()
        ;
    }*/
}
