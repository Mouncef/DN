<?php


namespace App\Controller\Backend;


use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class ClientsController
 * @package App\Controller\Backend
 * @Route("/admin/clients")
 */
class ClientsController extends Controller
{
    /**
     * @Route("", name="clients_list")
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param Request $request
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();

        $clients = $em->getRepository(User::class)->getClients();

        return $this->render('backend/clients/list.html.twig', [
            'clients'   => $clients
        ]);
    }

    /**
     * @Route("/{id}", name="client_view")
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param Request $request
     */
    public function viewAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $client = $em->getRepository(User::class)->find($id);

        if (!$client) {

            throw $this->createNotFoundException(
                'No client found for id '.$id
            );

        }

        return $this->render('backend/clients/view.html.twig', [
            'client'   => $client
        ]);
    }
}