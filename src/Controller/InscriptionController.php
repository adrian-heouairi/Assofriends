<?php

namespace App\Controller;

/**
* importation des differents components qui vont nous servir pour cette classe
*/
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
* importation de la classe qui va nous servir ici
*/
use App\Entity\User;

/**
* classe InscriptionController qui va permettre de s'inscrire
*
* créé un objet de type User
* créé un formulaire avec différents champs pour remplir les données de la personne qui s'inscrit
* remplit les données de l'objet de type User avec les informations qui ont été rentrées dans le formulaire
* sauvegarde dans la base de données les informations de l'objet de type User
*/
class InscriptionController extends AbstractController {
    /**
    * fonction nouveau qui reçoit une requête HTTP faite par le navigateur, la traite, et renvoie une réponse HTML qui contient la page HTML finale
    *
    * @param Request $request (requête HTTP faite par le navigateur)
    * @param UserPasswordEncoderInterface $passwordEncoder
    *
    * @return Response reponse HTML (page HTML finale)
    *
    * @Route("/inscription")
    */
    public function nouveau(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response {
        if ($this->getUser()) {
            return $this->redirectToRoute('accueil');
        }

        // Création du formulaire
        $user = new User();
        $form = $this->createFormBuilder($user)
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class)
            ->add('save', SubmitType::class, ['label' => 'Créer compte'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) { // Si l'utilisateur appelle cette page avec le bouton "Soumettre"
            $user->setPassword($passwordEncoder->encodePassword($user, $user->getPassword()));

            // Sauvegarde dans la base de données
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('inscription.html.twig',
               ['titre' => "Créer un compte", 'formulaire' => $form->createView()]);
    }
}
