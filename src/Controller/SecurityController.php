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
     * @Route("/inscription", name="app_inscription")
     */
    public function inscription(Request $requeteHTTP, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(UtilisateurPremConnexionType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $email = $form['email']->getData();
            $login = explode('@',$email);
        }
        
        return $this->render('pro_stage/formulaireEntreprise.html.twig',['vueFormulaireInscription' => $formulaireInscription -> createView()]);  
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
