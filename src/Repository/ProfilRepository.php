<?php

namespace App\Repository;

use App\Utils\Constant;
use Doctrine\ORM\EntityRepository;

class ProfilRepository extends EntityRepository
{

    public function getProfilMember()
    {
        $query = $this->createQueryBuilder('p')
            ->where('p.profilLib = :profil')
            ->setParameter('profil',Constant::PROFIL_MEMBER)
        ;

        return $query->getQuery()->getOneOrNullResult();
    }

    public function getProfilClient()
    {
        $query = $this->_em->createQueryBuilder('p')
            ->where('p.profilLib = :profil')
            ->setParameter('profil',Constant::PROFIL_CLIENT)
        ;

        return $query->getQuery()->getOneOrNullResult();
    }

    public function getProfilManager()
    {
        $query = $this->_em->createQueryBuilder('p')
            ->where('p.profilLib = :profil')
            ->setParameter('profil',Constant::PROFIL_MANAGER)
        ;

        return $query->getQuery()->getOneOrNullResult();
    }

    public function getProfilAdmin()
    {
        $query = $this->_em->createQueryBuilder('p')
            ->where('p.profilLib = :profil')
            ->setParameter('profil',Constant::PROFIL_ADMIN)
        ;

        return $query->getQuery()->getOneOrNullResult();
    }

    public function getProfilSuperAdmin()
    {
        $query = $this->_em->createQueryBuilder('p')
            ->where('p.profilLib = :profil')
            ->setParameter('profil',Constant::PROFIL_SUPER_ADMIN)
        ;

        return $query->getQuery()->getOneOrNullResult();
    }

}
