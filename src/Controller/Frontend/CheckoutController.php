<?php

namespace App\Controller\Frontend;

use App\Entity\Address;
use App\Entity\Cart;
use App\Entity\Order;
use App\Entity\Param;
use App\Entity\Payment;
use App\Entity\PayPalDetail;
use App\Form\AddressType;
use App\Service\BrainTreeService;
use App\Service\PaypalService;
use App\Utils\Constant;
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

        $ordering = $em->getRepository(Param::class)->find(Constant::ORDERING);
        if ($ordering->getEnabled()) {
            $cart = $em->getRepository(Cart::class)->find($cart);
            $gateway = BrainTreeService::getGateway();
            $address = new Address();
            $form = $this->createForm(AddressType::class, $address);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()){


//            var_dump($doneUrl); die;


                $country = $request->request->get("country");
                $city = $request->request->get("city");
                $usTotal = $request->request->get("us_total_order");
                $shippment = $request->request->get("shippment_order");
                if ((float)$shippment > 0){
                    $shippment = 70;
                } else {
                    $shippment = 0;
                }
                $address->setCountry($country);
                $address->setCity($city);

                $em->persist($address);

                $order = new Order();
                $order->setAddress($address);
                $order->setCart($cart);
                $orders = $em->getRepository(Order::class)->findAll();
                $code = '#0000'.$cart->getCartId()."_#00".$cart->getUser()->getUserId();
                foreach ($orders as $o){
                    if ($o->getOrderCode() === $code ){
                        $code = '#0000'.$cart->getCartId()."_#00".$cart->getUser()->getUserId()."_00".uniqid();
                    }
                }
                $order->setOrderCode($code);
                $order->setOrderTotal($usTotal);
                $order->setOrderShipping($shippment);

                $em->persist($order);


                $link = 'http://darnawal.com';
//            var_dump($request->request->get('payment_method_nonce')); die;
                $paymentType = $request->request->get('payement_type');
                $paymentInfos = $request->request;
                $doneUrl = 'http://'.$request->getHttpHost().$this->get('router')->generate('checkout_done');
                $cancelUrl = 'http://'.$request->getHttpHost().$this->get('router')->generate('checkout_cancel');

                $em->flush();

                if ($paymentType === "paypal") {
                    if (!is_null($cart)) {
                        $paypalService = new PaypalService();
                        $link = $paypalService->paypalPayment($order, $doneUrl, $cancelUrl);

                    }
                } else {
                    $metodPay = $request->request->get('payment_method_nonce');
                    $braintree = new BrainTreeService();
                    $link = $braintree->getCredentiels($metodPay, $doneUrl, $cancelUrl, $order, $em);
                }


                if ($link === $doneUrl || $link === $doneUrl."?order=".$order->getOrderId()) {
                    $cart->setCheckedAt(new \DateTime('now'));
                    $this->addFlash('success','Your order has been passed successfully ');
                    $em->flush();
                }



                return new RedirectResponse($link, 302);
            }

            $result = 'frontend/checkout/index.html.twig';
            return $this->render($result, ['cart'  =>  $cart,'form' => $form->createView(),'gateway'   =>  $gateway]);
        } else {
            $result = 'frontend/checkout/disabledOrdering.html.twig';
            return $this->render($result);
        }




    }

    /**
     * @param Request $request
     * @Route("/checkout/done/", name="checkout_done")
     * @return Response
     */
    public function done(Request $request){
        $view = 'frontend/index.html.twig';
        $order = '';
        $code = $request->query->get('order');

        $paymentId = $request->query->get('paymentId');
        $token = $request->query->get('token');
        $PayerID = $request->query->get('PayerID');
        if ($paymentId && $token && $PayerID) {
            $paypalService = new PaypalService();
            $result = $paypalService->paypalDone($paymentId,$token,$PayerID);
            if ($result){

                $orderCode = $result['OrderId'];
                $status = $result['State'];

                $em = $this->getDoctrine()->getManager();

                $order = $em->getRepository(Order::class)->findOneBy([
                    'orderCode' => $orderCode
                ]);

                if ($status === 'approved') {

                    $payment = new Payment();
                    $payment->setDate(new \DateTime($result['Date']));
                    $payment->setState($status);

                    $paypalDetail = new PayPalDetail();
                    $paypalDetail->setPaypalPaymentId($paymentId);
                    $paypalDetail->setPaypalToken($token);
                    $paypalDetail->setPaypalPayerId($PayerID);
                    $paypalDetail->setPaypalTotal($result['Total']);
                    $paypalDetail->setPaypalCurrency($result['Currency']);
                    $paypalDetail->setPaypalSubTotal($result['SubTotal']);
                    $paypalDetail->setPaypalMerchant($result['MerchantId']);
                    $paypalDetail->setPaypalMerchantMail($result['MerchantMail']);
                    $paypalDetail->setPaypalPayerFirstName($result['PayerInfo']['PayerFirstName']);
                    $paypalDetail->setPaypalPayerLastName($result['PayerInfo']['PayerLastName']);
                    $paypalDetail->setPaypalPayerMail($result['PayerInfo']['PayerMail']);

                    $payment->setPaypalDetail($paypalDetail);

                    $order->setPayment($payment);
                    $order->setIsPaid(1);
                    $order->setOrderTotal($result['Total']);
                    $order->getCart()->setCheckedAt(new \DateTime('now'));

                    $em->persist($paypalDetail);
                    $em->persist($payment);
                    $em->persist($order);

                    $em->flush();

                    $view = 'frontend/checkout/done.html.twig';

                } else {

                    $view = 'frontend/checkout/cancel.html.twig';
                }
            } else {
                $view = 'frontend/checkout/cancel.html.twig';
            }
        } else {

            $view = 'frontend/checkout/done.html.twig';
            $order = $this->getDoctrine()->getManager()->getRepository(Order::class)->find($code);
        }


        return $this->render($view, [
            'order' =>  $order
        ]);
    }

    /**
     * @param Request $request
     * @Route("/checkout/cancel/", name="checkout_cancel")
     * @return Response
     */
    public function cancel(Request $request) {
        return $this->render('frontend/checkout/cancel.html.twig');
    }
}
