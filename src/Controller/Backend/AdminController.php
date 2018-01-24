<?php

namespace App\Controller\Backend;

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
}
