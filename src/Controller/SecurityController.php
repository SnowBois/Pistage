<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Form\UtilisateurChangerMdpType;

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


    /**
     * @Route("/changerMdp", name="app_changerMdp")
     */
    public function changerDeMotDePasse(Request $requeteHTTP, EntityManagerInterface $manager,UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $form = $this->createForm(UtilisateurChangerMdpType::class);
        $form->handleRequest($requeteHTTP);
        $user = $this->getUser();
        if ($passwordEncoder->isPasswordValid($user, $form->get('oldPassword')->getData())){
            if ($form->isSubmitted() && $form->isValid()){
                
                $newPassWord = $form['newPassword']->getData();
                
                $encodagePassword = $passwordEncoder->encodePassword($user,$newPassWord);
                $user->setPassword($encodagePassword);
                $manager->persist($user);
                $manager->flush();

                return $this->redirectToRoute('pistage_profil');
            }
        }   
        return $this->render('security/formulaireChangementDeMdp.html.twig',['vueFormulaireChangementMdp' => $form -> createView()]);  
    }
    
}
