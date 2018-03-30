<?php
/**
 * Created by PhpStorm.
 * User: Mouncef
 * Date: 30/03/2018
 * Time: 23:32
 */

namespace App\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class ContactController extends Controller
{
    /**
     * @Route("/Contact", name="contact_index")
     */
    public function index(){
        return $this->render('frontend/contact/index.html.twig');
    }
}