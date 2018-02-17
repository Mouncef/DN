<?php

namespace App\Controller\Backend;

use App\Entity\Profil;
use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class MemberController
 * @package App\Controller\Backend
 * @Route("/admin/members")
 */
class MemberController extends Controller
{
    /**
     * @Route("", name="members_list")
     */
    public function list()
    {
        $em = $this->getDoctrine()->getManager();

        $profilMember = $em->getRepository(Profil::class)->getProfilMember();
        $members = $em->getRepository(User::class)->getMembers($profilMember);

        return $this->render('backend/members/list.html.twig', [
            'members'   => $members
        ]);
    }
}
