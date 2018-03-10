<?php

namespace App\Controller\Frontend;

use App\Entity\Address;
use App\Entity\Cart;
use App\Entity\Order;
use App\Form\AddressType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class CheckoutController extends Controller
{
    /**
     * @Route("/checkout/{cart}", name="checkout_index")
     */
    public function index(Request $request, $cart){

        $em = $this->getDoctrine()->getManager();

        $cart = $em->getRepository(Cart::class)->find($cart);
        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){


            $em->persist($address);



            $order = new Order();
            $order->setAddress($address);
            $order->setCart($cart);
            $code = $cart->getCartId()."_".$cart->getUser()->getUserId();
            $order->setOrderCode($code);

            $em->persist($order);



            $cart->setCheckedAt(new \DateTime('now'));

            $this->addFlash('success','Your order has been passed successfully ');

            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('frontend/checkout/index.html.twig', [
            'cart'  =>  $cart,
            'form' => $form->createView(),
        ]);
    }
}
