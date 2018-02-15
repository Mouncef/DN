<?php

namespace App\Controller\Backend;

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

        $members = $em->getRepository(User::class)->findAll();

        return $this->render('backend/subscribers/list.html.twig', [
            'members'   => $members
        ]);
    }
}
