<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\UtilisateurPremConnexionType;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/premiereConnexion", name="app_premiere_connexion")
     */
    public function premiereConnexion(Request $requeteHTTP, EntityManagerInterface $manager): Response
    {
        $formulairePremiereConnexion = $this->createForm(UtilisateurPremConnexionType::class);
        $formulairePremiereConnexion->handleRequest($requeteHTTP);
        if ($formulairePremiereConnexion->isSubmitted() && $formulairePremiereConnexion->isValid()){
            $email = $form['email']->getData();
            $chaineCoupee = explode('@',$email);
            $login = $chaineCoupee[0];

        }
        
        return $this->render('security/premiereConnexion.html.twig',['vueFormulairePremiereConnexion' => $formulairePremiereConnexion -> createView()]);  
    }


    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
