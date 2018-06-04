<?php

namespace App\Controller\Backend;

use App\Entity\Param;
use App\Utils\Constant;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class AdminController
 * @package App\Controller\Backend
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("", name="admin")
     */
    public function index()
    {
        $user = $this->getUser();


        // replace this line with your own code!
        return $this->render('backend/index.html.twig', [
            'path'  => str_replace($this->getParameter('kernel.project_dir').'/', '', __FILE__),
            'user'  =>  $user
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/Enable/Ordering", name="enable_ordering")
     */
    public function EnableOrdering(){
        $em = $this->getDoctrine()->getManager();
        $ordering = $em->getRepository(Param::class)->find(Constant::ORDERING);
        if ($ordering) {
            $ordering->setEnabled(true);
            $this->addFlash('success','Ordering has been enabled');
        }
        $em->flush();

        return $this->redirectToRoute('admin');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/Disable/Ordering", name="disable_ordering")
     */
    public function DisableOrdering(){
        $em = $this->getDoctrine()->getManager();
        $ordering = $em->getRepository(Param::class)->find(Constant::ORDERING);
        if ($ordering) {
            $ordering->setEnabled(false);
            $this->addFlash('danger','Ordering has been disabled');
        }
        $em->flush();

        return $this->redirectToRoute('admin');
    }
}
