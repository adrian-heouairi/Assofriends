<?php

namespace App\Controller;

/**
* importation des differents components qui vont nous servir pour cette classe
*/
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

/**
* importation des differentes classes qui vont nous servir ici
*/
use App\Entity\EnvoiMail;
use App\Entity\Association;
use App\Entity\User;
use App\Entity\Adhesion;

/**
* classe TableauDeBordPublipostageController qui va permettre sur le tableau de bord d'envoyer des mails en masse
*
* créé plusieurs objets de type : EnvoiMail et Email
* créé un formulaire avec différents champs pour saisir les informations du mail à envoyer
* récupère la liste de tous les mails des adhérents dans la base de données
* l'objet Email sert à envoyer le mail aux adhérents
* envoi l'email
*/
class TableauDeBordPublipostageController extends AbstractController {
    /**
    * fonction nouveau qui reçoit une requête HTTP faite par le navigateur, la traite, et renvoie une réponse HTML qui contient la page HTML finale
    *
    * @param Request $request (requête HTTP faite par le navigateur)
    * @param Association $association (objet association représentant l'association actuelle)
    * @param String $listeEmails (liste de tous les emails des adhérents)
    * @param MailerInterface $mailer (permet d'envoyer le mail)
    *
    * @return Response reponse HTML (page HTML finale)
    *
    * @Route("/tableau-de-bord/publipostage/{id}/{listeEmails}", defaults={"listeEmails"=""})
    */
    public function nouveau(Request $request, Association $association, string $listeEmails, MailerInterface $mailer): Response {
        $user = $this->getUser();
		if ($user !== $association->getUserGerant()) {
			return $this->render('erreur.html.twig',
			['messageDErreur' => "Vous (".$user->getEmail().") n'êtes pas le gérant de l'association ".$association->getNom()]);
		}

        /**
        * création d'un objet EnvoiMail
        */
        $envoiMail = new EnvoiMail();

        /**
        * céeation d'un formulaire avec différents champs pour saisir les informartions pour le mail
        */
        $form = $this->createFormBuilder($envoiMail)
            ->add('objet', TextType::class)
            ->add('message', TextareaType::class)
            ->add('envoi', SubmitType::class, ['label' => 'Envoyer'])
            ->getForm();


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) { // Si l'utilisateur appelle cette page avec le bouton soumettre

          if ($listeEmails == '') {
		      $adhesionRepository = $this->getDoctrine()->getRepository(Adhesion::class);
		      $adhesions = $adhesionRepository->findBy(['association' => $association]);
		      $liste = [];
		      foreach($adhesions as $adhesion) $liste[]=$adhesion->getUserAdherent()->getEmail();
		      if ($liste == []) return $this->render('erreur.html.twig', ['messageDErreur' => "Le mail ne peut pas être envoyé car vous n'avez aucun adhérent"]);
	      } else {
	      		$liste = explode(',', $listeEmails);
  		  }

          /**
          * creation d'un objet Email pour envoyer un mail à tous les adhérents
          */
           $email = (new Email())
           ->from('assofriendsl3@gmail.com')
           ->bcc(...$liste)
           ->subject($envoiMail->getObjet())
           ->html($envoiMail->getMessage());

           /**
           * envoi de l'email
           */
            $mailer->send($email);

          return $this->render('tableau-de-bord-publipostage.html.twig',
               ['message' => "Le mail a bien été envoyé à : ".implode(',',$liste), 'formulaire' => $form->createView(), 'association' => $association ]);
        }

        return $this->render('tableau-de-bord-publipostage.html.twig',
               ['message' => null, 'formulaire' => $form->createView(), 'association' => $association]);
    }
}
