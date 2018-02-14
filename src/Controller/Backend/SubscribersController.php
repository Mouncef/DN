<?php

namespace App\Controller\Backend;

use App\Entity\Subscribers;
use App\Service\PDFGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SubscribersController
 * @package App\Controller\Backend
 * @Route("/admin/subscribers")
 */
class SubscribersController extends Controller
{
    /**
     * @Route("", name="subscribers_list")
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param Request $request
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();

        $subscribers = $em->getRepository(Subscribers::class)->findAll();

        return $this->render('backend/subscribers/list.html.twig', [
            'subscribers'   => $subscribers
        ]);
    }

    /**
     * @Route("/edit/{id}", name="subscriber_edit", requirements={"id": "\d+"})
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @internal param FileUploader $fileUploader
     */
    public function edit(Request $request, $id){

        $em = $this->getDoctrine()->getManager();
        $subscriber =  $em->getRepository(Subscribers::class)->find($id);

        if (!$subscriber) {

            throw $this->createNotFoundException(
                'No subscriber found for id '.$id
            );

        }

        $form = $this->createFormBuilder($subscriber)
            ->add('email', EmailType::class)
            ->getForm();
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid() && !$form->isEmpty()){

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash('success','Email Modified !');

            return $this->redirectToRoute('subscribers_list');
        }

        return $this->render('backend/subscribers/edit.html.twig', array(
            'form' => $form->createView(),
            'subscriber' =>  $subscriber
        ));

    }

    /**
 * @Route("delete/{id}", name="subscriber_delete")
 */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $subscriber =  $em->getRepository(Subscribers::class)->find($id);

        if (!$subscriber) {

            throw $this->createNotFoundException(
                'No subscriber found for id '.$id
            );

        }

        $em->remove($subscriber);
        $em->flush();

        $this->addFlash('danger','Subscriber Deleted !');

        return $this->redirectToRoute('subscribers_list');
    }

    /**
     * @Route("/list/PDF", name="subscribers_list_pdf")
     */
    public function snappy(PDFGenerator $generator)
    {
        $em = $this->getDoctrine()->getManager();

        $subscribers = $em->getRepository(Subscribers::class)->findAll();
        $html = $this->renderView('backend/subscribers/listPdf.html.twig',[
            'subscribers'   => $subscribers
        ]);
        $generator->generatePDF($html, 'Subscribers_List');

    }
}
