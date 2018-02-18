<?php

namespace App\Controller\Frontend;

use App\Entity\Cart;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
    /**
     * @Route("/cart", name="cart_index")
     */
    public function index(){

        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $cart = $em->getRepository(Cart::class)->getUserCart($user);

        return $this->render('frontend/cart/index.html.twig', [
            'cart'  =>  $cart
        ]);
    }

    /**
     * @Route("/ClearCart", name="clear_articles_from_cart")
     */
    public function clearCart(){
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $cart = $em->getRepository(Cart::class)->getUserCart($user);

        if ($cart) {
            $em->remove($cart);
        }
        $em->flush();

        $this->addFlash('danger','Cart cleared !');

        return $this->redirectToRoute('cart_index');
    }
}
