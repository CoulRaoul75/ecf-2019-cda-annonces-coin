<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login-user", name="security-user")
     * @param AuthenticationUtils $helper
     * @return Response
     */
    public function userLogin(AuthenticationUtils $helper){

        return $this->render('security/login.html.twig', [
            'lastUserName' => $helper->getLastUsername(),
            'error' => $helper->getLastAuthenticationError(),
            'formTitle' => 'Identifie-toi faire ton coin d\'annonces',
            'formAction' => $this->generateUrl('security-user')
        ]);
    }

}