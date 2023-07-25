<?php

namespace App\Controller;

/**
* importation des differentes classes qui vont nous servir ici
*/
use App\Entity\User;
use App\Entity\Association;

/**
* importation des differents components qui vont nous servir pour cette classe
*/
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
* classe CreationAssociationController qui va permettre de créer une association
*
* créé un objet de type Association
* créé un formulaire avec différents champs pour remplir les données de l'association
* remplit les données de l'objet de type Association avec les informations qui ont été rentrées dans le formulaire
* sauvegarde dans la base de données les informations de l'objet de type Association
*/
class CreationAssociationController extends AbstractController {
    /**
    * fonction nouveau qui reçoit une requête HTTP faite par le navigateur, la traite, et renvoie une réponse HTML qui contient la page HTML finale
    *
    * @param Request $request (requête HTTP faite par le navigateur)
    * @param UserPasswordEncoderInterface $passwordEncoder
    *
    * @return Response reponse HTML (page HTML finale)
    *
    * @Route("/creation-association")
    */
    public function nouveau(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        // Création du formulaire
        $association = new Association();
        $form = $this->createFormBuilder($association)
            ->add('nom', TextType::class)
            ->add('description', TextareaType::class)
            ->add('prixAdhesionMensuelle', NumberType::class)
            ->add('save', SubmitType::class, ['label' => 'Créer association'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) { // Si l'utilisateur appelle cette page avec le bouton soumettre
            $association->setUserGerant($this->getUser());
            $association->setFormuleActuelle(0);

            // Sauvegarde dans la base de données
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($association);
            $entityManager->flush();

            return $this->redirect('/tableau-de-bord/accueil/'.$association->getId());
        }

        return $this->render('creation-association.html.twig',
               ['titre' => "Créer une association", 'formulaire' => $form->createView()]);
    }
}
