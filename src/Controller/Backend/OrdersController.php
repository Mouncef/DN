<?php

namespace App\Controller\Backend;

use App\Entity\Order;
use App\Service\PDFGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class OrderController
 * @package App\Controller\Backend
 * @Route("/admin/orders")
 */
class OrdersController extends Controller
{
    /**
     * @Route("", name="order_list")
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param Request $request
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();

        $orders = $em->getRepository(Order::class)->findAll();

        return $this->render('backend/order/list.html.twig', [
            'orders'   => $orders
        ]);
    }

    /**
     * @Route("/{id}", name="order_view")
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param Request $request
     */
    public function viewAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $order = $em->getRepository(Order::class)->find($id);

        if (!$order) {

            throw $this->createNotFoundException(
                'No order found for id '.$id
            );

        }

        $order->setNotified(true);

        $em->flush();

        return $this->render('backend/order/view.html.twig', [
            'order'   => $order
        ]);
    }

    /**
     * @Route("/CheckPaiement/{id}", name="order_check_paiement")
     */
    public function checkPaiement($id)
    {
        $em = $this->getDoctrine()->getManager();
        $order =  $em->getRepository(Order::class)->find($id);

        if (!$order) {

            throw $this->createNotFoundException(
                'No order found for id '.$id
            );

        }

        $order->setIsPaid(true);

        $em->persist($order);
        $em->flush();

        $this->addFlash('success','Paiement Checked !');

        return $this->redirectToRoute('order_list');
    }

    /**
     * @Route("/CheckDelivery/{id}", name="order_check_delivery")
     */
    public function checkDelivery($id)
    {
        $em = $this->getDoctrine()->getManager();
        $order =  $em->getRepository(Order::class)->find($id);

        if (!$order) {

            throw $this->createNotFoundException(
                'No order found for id '.$id
            );

        }

        $order->setIsDelivered(true);

        $em->persist($order);
        $em->flush();

        $this->addFlash('success','Delivery Checked !');

        return $this->redirectToRoute('order_list');
    }

    /**
     * @Route("/Invoice/PDF/{id}", name="invoice_pdf")
     */
    public function snappy(PDFGenerator $generator, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $order = $em->getRepository(Order::class)->find($id);
        $html = $this->renderView('backend/order/invoice.html.twig',[
            'order'   => $order
        ]);
        $generator->generateInvoicePDF($html, 'order_'.$order->getOrderCode());

    }
}
