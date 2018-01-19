<?php

namespace App\Controller\Backend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        $user = $this->getUser();
        // replace this line with your own code!
        return $this->render('@Maker/demoPage.html.twig', [
            'path'  => str_replace($this->getParameter('kernel.project_dir').'/', '', __FILE__),
            'user'  =>  $user
        ]);
    }
}
