<?php

namespace App\Controller;

/**
* importation des differents components qui vont nous servir pour cette classe
*/
use App\Entity\AjoutAdherent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

/**
* importation des differentes classes qui vont nous servir ici
*/
use App\Entity\Adhesion;
use App\Entity\Association;
use App\Entity\User;
use App\Entity\EnvoiMail;

/**
* classe TableauDeBordAjoutAdherentController qui va permettre sur le tableau de bord d'ajouter un adhérent manuellement
*
* créé plusieurs objets de type : Adhesion, User et Email
* créé un formulaire avec différents champs pour saisir les informartions d'un adhérent
* remplit les données des objets de type Adhesion et User avec les informations qui ont été rentrées dans le formulaire
* sauvegarde dans la base de données les informations des objets de type  Adhesion et User
* l'objet Email sert à envoyer un mail à l'adhérent qui vient d'être ajouté
* envoi l'email
*/
class TableauDeBordAjoutAdherentController extends AbstractController {
    /**
    * fonction nouveau qui reçoit une requête HTTP faite par le navigateur, la traite, et renvoie une réponse HTML qui contient la page HTML finale
    *
    * @param Request $request (requête HTTP faite par le navigateur)
    * @param Association $association (objet association représentant l'association actuelle)
    * @param ValidatorInterface $validator (permet de valider qqch)
    * @param MailerInterface $mailer (permet d'envoyer le mail)
    *
    * @return Response reponse HTML (page HTML finale)
    *
    * @Route("/tableau-de-bord/ajout-adherent/{id}")
    */
    public function nouveau(Request $request, Association $association, ValidatorInterface $validator, MailerInterface $mailer): Response {
        $user = $this->getUser();
		if ($user !== $association->getUserGerant()) {
			return $this->render('erreur.html.twig',
			['messageDErreur' => "Vous (".$user->getEmail().") n'êtes pas le gérant de l'association ".$association->getNom()]);
		}

        /**
        * création d'un objet AjoutAdherent
        */
        $ajoutAdherent = new AjoutAdherent();

        $date = new \DateTime();
        $date->modify('+1 year');
        $ajoutAdherent->setDateDeFinAdhesion($date);

        /**
        * céeation d'un formulaire avec différents champs pour saisir les informartions d'un adhérent
        */
        $form = $this->createFormBuilder($ajoutAdherent)
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('email', EmailType::class)
            ->add('dateDeFinAdhesion', DateType::class)
            ->add('save', SubmitType::class, ['label' => 'Ajouter adhérent'])
            ->getForm();


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) { // Si l'utilisateur appelle cette page avec le bouton soumettre

           $userRepository = $this->getDoctrine()->getRepository(User::class);
           $futurAdherent = $userRepository->findOneBy(['email' => $ajoutAdherent->getEmail()]);
           if ($futurAdherent === null) {
             /**
             * création d'un objet User pour créer un nouvel adhérent
             */
             $futurAdherent = new User();

             /**
             * on remplit ses données avec les informations qui ont été rentrées dans le formulaire
             */
             $futurAdherent->setNom($ajoutAdherent->getNom());
             $futurAdherent->setPrenom($ajoutAdherent->getPrenom());
             $futurAdherent->setEmail($ajoutAdherent->getEmail());
             $futurAdherent->setPassword('');
             // $futurAdherent n'aura pas de mot de passe et ne pourra donc pas se connecter
             // tant qu'il n'aura pas « claim » son compte

             $errors = $validator->validate($futurAdherent); if (count($errors) > 0) { return new Response((string)$errors); }

             /**
             * sauvegarde dans la base de données
             */
             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($futurAdherent);
             //$entityManager->flush(); // Normalement un seul flush() à la fin suffit
           }

           /**
           * création d'un objet Adhesion
           */
           $adhesion = new Adhesion();

           /**
           * on remplit ses données avec les informations qu'on a
           */
           $adhesion->setUserAdherent($futurAdherent);
           $adhesion->setAssociation($association);
           $adhesion->setDateFin($ajoutAdherent->getDateDeFinAdhesion());
           $adhesion->setRenouvellementAutomatique(false);
           $adhesion->setRelanceEnvoyee(false);

           $errors = $validator->validate($adhesion); if (count($errors) > 0) { return new Response((string)$errors); }

           /**
           * sauvegarde dans la base de données
           */
           $entityManager = $this->getDoctrine()->getManager();
           $entityManager->persist($adhesion);
           $entityManager->flush();

           /**
           * creation d'un objet Email pour envoyer un mail à l'adhérent qui vient d'etre ajouté
           */
           $email = (new Email())
            ->from('assofriendsl3@gmail.com')
            ->to($futurAdherent->getEmail())
            ->subject("Confirmation automatique d'adhésion")
            ->html("Ceci est un mail automatique pour vous confirmer que vous vous êtes bien inscrit à ".$association->getNom());

            /**
            * envoi de l'email
            */
            $mailer->send($email);

          //return new Response("<html><body>L'adhérent a bien été ajouté : ".$ajoutAdherent->getEmail().'</body></html>');
          return $this->render('tableau-de-bord-ajout-adherent.html.twig',
               ['message' => "L'adhérent a bien été ajouté", 'formulaire' => $form->createView(), 'association' => $association]);
        }

        return $this->render('tableau-de-bord-ajout-adherent.html.twig',
               ['message' => null, 'formulaire' => $form->createView(), 'association' => $association]);
    }
}
