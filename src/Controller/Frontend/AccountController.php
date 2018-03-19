<?php
/**
 * Created by PhpStorm.
 * User: Mouncef
 * Date: 19/03/2018
 * Time: 21:15
 */

namespace App\Controller\Frontend;


use App\Entity\Order;
use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AccountController extends Controller
{

    /**
     * @Route("/account", name="account_index")
     */
    public function index(){

        $em = $this->getDoctrine()->getManager();
        $userId = $this->getUser()->getUserId();
        $user = $em->getRepository(User::class)->find($userId);

        return $this->render('frontend/account/index.html.twig', [
            'user'  =>  $user,
        ]);
    }

    /**
     * @Route("/order/{id}", name="account_order_detail")
     */
    public function orderDetail($id) {
        $em = $this->getDoctrine()->getManager();
        $order = $em->getRepository(Order::class)->find($id);

        return $this->render('frontend/account/orderDetail.html.twig', [
            'order'  =>  $order,
        ]);

    }

}