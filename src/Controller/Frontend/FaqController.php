<?php
/**
 * Created by PhpStorm.
 * User: Mouncef
 * Date: 16/04/2018
 * Time: 20:49
 */

namespace App\Controller\Frontend;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FaqController extends Controller
{
    /**
     * @Route("/FAQ", name="FAQ")
     */
    public function index() {
        return $this->render('frontend/FAQ/index.html.twig');
    }
}