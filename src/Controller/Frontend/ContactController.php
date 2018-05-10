<?php
/**
 * Created by PhpStorm.
 * User: Mouncef
 * Date: 30/03/2018
 * Time: 23:32
 */

namespace App\Controller\Frontend;

use App\Entity\Mail;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class ContactController extends Controller
{
    /**
     * @Route("/Contact", name="contact_index")
     */
    public function index(){
        return $this->render('frontend/contact/index.html.twig');
    }

    /**
     * @Route("/SendMail", name="send_mail")
     * @param Request $request
     * @param \Swift_Mailer $mailer
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function sendMail(Request $request, \Swift_Mailer $mailer){

        $firstName = $request->get('_first_name');
        $lastName = $request->get('_last_name');
        $email = $request->get('_email');
        $subject = $request->get('_subject');
        $message = $request->get('_message');

        $em = $this->getDoctrine()->getManager();

        $mail = (new \Swift_Message())
            ->setFrom($email)
            ->setTo('contact@darnawal.com')
            ->setSubject($subject)
            ->setBody(
                $this->renderView('frontend/contact/mail.html.twig',[
                    'firstName' => $firstName,
                    'lastName' => $lastName,
                    'Email' => $email,
                    'Subject' => $subject,
                    'Message' => $message,
                ]),'text/html'
            )
        ;

        $mailer->send($mail);

        $emailBD = new Mail();
        $emailBD->setFirstName($firstName);
        $emailBD->setLastName($lastName);
        $emailBD->setEmail($email);
        $emailBD->setSubject($subject);
        $emailBD->setMessage($message);

        $em->persist($emailBD);

        $em->flush();

        $this->addFlash('success', 'Your mail has been sent to the website owner');

        /*return $this->render('frontend/contact/mail.html.twig',[
            'firstName' => $firstName,
            'lastName' => $lastName,
            'Email' => $email,
            'Subject' => $subject,
            'Message' => $message,
        ]);*/

        return $this->redirectToRoute('contact_index');

    }
}