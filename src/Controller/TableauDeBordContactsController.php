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
use Symfony\Component\Validator\Validator\ValidatorInterface;
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
* classe TableauDeBordContactsController qui va permettre sur le tableau de bord d'afficher la liste des adhérents de son association
*
* accède à la liste des adhésions pour son association
*/
class TableauDeBordContactsController extends AbstractController {
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
    * @Route("/tableau-de-bord/contacts/{id}")
    */
    public function nouveau(Request $request, Association $association, ValidatorInterface $validator, MailerInterface $mailer): Response {
        $user = $this->getUser();
		if ($user !== $association->getUserGerant()) {
			return $this->render('erreur.html.twig',
			['messageDErreur' => "Vous (".$user->getEmail().") n'êtes pas le gérant de l'association ".$association->getNom()]);
		}


		$adhesionRepository = $this->getDoctrine()->getRepository(Adhesion::class);
        $adhesions = $adhesionRepository->findBy(['association' => $association]);
        //$liste = [];
        //foreach($adhesions as $adhesion) $liste[]=$adhesion->getUserAdherent()->getEmail();

		return $this->render('tableau-de-bord-contacts.html.twig',
               ['adhesions' => $adhesions, 'association' => $association]);
    }
}
