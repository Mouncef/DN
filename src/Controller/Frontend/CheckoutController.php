<?php

namespace App\Controller\Frontend;

use App\Entity\Address;
use App\Entity\Cart;
use App\Entity\Order;
use App\Form\AddressType;
use App\Service\PaypalService;
use Http\Client\Exception;
use KMJ\PayPalBridgeBundle\Service\BridgeService;
use Payum\Core\Request\GetHumanStatus;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


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

            $link = '';
            if (!is_null($cart)) {
                $paypalService = new PaypalService();
                $link = $paypalService->paypalPayment($cart);
            }


            $em->persist($address);

            $order = new Order();
            $order->setAddress($address);
            $order->setCart($cart);
            $code = '#0000'.$cart->getCartId()."_#00".$cart->getUser()->getUserId();
            $order->setOrderCode($code);

            $em->persist($order);



            $cart->setCheckedAt(new \DateTime('now'));

            $this->addFlash('success','Your order has been passed successfully ');

            $em->flush();


            return new RedirectResponse($link, 302);
        }

        return $this->render('frontend/checkout/index.html.twig', [
            'cart'  =>  $cart,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @Route("/checkout/done/", name="checkout_done")
     * @return Response
     */
    public function done(Request $request){
        $paymentId = $request->query->get('paymentId');
        $token = $request->query->get('token');
        $PayerID = $request->query->get('PayerID');

        $paypalService = new PaypalService();
        $result = $paypalService->paypalDone($paymentId,$token,$PayerID);

        var_dump($result);
        die;
        return $this->render('frontend/checkout/done.html.twig');
    }
}
