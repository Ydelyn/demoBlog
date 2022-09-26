<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use App\Entity\User;
use App\Form\RegistrationType;

use Doctrine\ORM\EntityManagerInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/security", name="security")
     */
    public function index()
    {
        return $this->render('security/index.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }

    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder) // on appel en argument la class Request pour executer la requete et insérerdans la BDD
    {
        $user = new User(); // on précise à quelle entité va être relié notreformulaire
        $form = $this->createForm(registrationType::class, $user); // on appel la classe qui permetde construire le formulaire relié à l'entité user
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword()); // on lui demande d'encoder le mot de passe et lui envoi un argument de type $user puisque c'est au moment de l'insertion d'un utilisateurque l'on veut crypter le mot de passe et en 2ème argument on lui envoi le champ 'password'
            $user->setPassword($hash); // on appel le setteur du mot pde passe et on lui demandede le hacher
            $manager->persist($user); // on fait persisiter dans le temps l'utilisateur, prépare toi à la sauvegarder
            $manager->flush(); // on lance la requete d'insertion
            return $this->redirectToRoute('security_login'); // on redirige vers la page login aprés inscription
        }
        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/connexion", name="security_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // affiche le message d'erreur
        $error = $authenticationUtils->getLastAuthenticationError();
        // recupère le dernier username saisi par l'internaute
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @Route("\deconnexion", name="security_logout")
     */
    public function logout()
    {
        // cette fonction ne retourne rien, il nous suffit d'avoir une route pour la deconnexion, une fois créer, modifier le providers form_login
    }
}
