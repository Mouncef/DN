<?php

namespace App\Controller;

use App\Entity\Profil;
use App\Entity\User;
use App\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     * @param AuthenticationUtils $authUtils
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login(AuthenticationUtils $authUtils)
    {
        // get the Login error if there is one
        $error = $authUtils->getLastAuthenticationError();

        // Last username entered by the user
        $lastUsername = $authUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' =>  $lastUsername,
            'error' =>  $error
        ]);
    }

    /**
     * @Route("/register", name="register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $em = $this->getDoctrine()->getManager();

        $user = new User();

        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $password = $encoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $profilMember = $em->getRepository(Profil::class)->getProfilMember();
            $user->setProfil($profilMember);

            $em->persist($user);
            $em->flush();

            $this->addFlash('success','Account successfully created ');

            return $this->redirectToRoute('homepage');
        }else {
            $this->addFlash('danger','Fields  email and login must be unique');
        }

        return $this->render('security/register.html.twig', [
            'user'  =>  $user,
            'form'  =>  $form->createView(),
        ]);

    }

    /**
     * @Route("/forgotPassword", name="forgot_password")
     */
    public function forgotPassword(Request $request)
    {
        $email = $request->get('email');
        if ($email)
        {
            $isIdentical = false;
            $em = $this->getDoctrine()->getManager();
            $emails = $em->getRepository(User::class)->findAll();

            foreach ($emails as $mail){
                if ($mail->getEmail() == $email){
                    $isIdentical = true;
                }
            }

            if ($isIdentical)
            {
                $this->addFlash('success','An Email has been sent to you !');
                $this->sendNewPasswordMail($email);

            }else {
                $this->addFlash('danger','There is no email corresponding in our database !');

            }
        }
        return $this->render('security/emailCheck.html.twig');
    }


    public function sendNewPasswordMail($email)
    {
        return false;
    }
}
