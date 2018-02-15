<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProfilRepository")
 * @ORM\Table(name="ref_profil")
 */
class Profil
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", name="profil_id")
     */
    private $profilId;

    /**
     * @ORM\Column(type="string", name="profil_lib", length=255)
     */
    private $profilLib;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="profil")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getProfilId()
    {
        return $this->profilId;
    }

    /**
     * @return Collection|Product[]
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @return mixed
     */
    public function getProfilLib()
    {
        return $this->profilLib;
    }

    /**
     * @param mixed $profilLib
     */
    public function setProfilLib($profilLib)
    {
        $this->profilLib = $profilLib;
    }


}
