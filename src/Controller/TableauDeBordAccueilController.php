<?php

namespace App\Controller;

/**
* importation des differents components qui vont nous servir pour cette classe
*/
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* importation de la classe qui va nous servir ici
*/
use App\Entity\Association;

/**
* classe TableauDeBordAccueilController qui va permettre sur le tableau de bord d'afficher la page d'accueil
*/
class TableauDeBordAccueilController extends AbstractController {
	/**
	* fonction tdbAccueil qui reçoit une requête HTTP faite par le navigateur, la traite, et renvoie une réponse HTML qui contient la page HTML finale
	*
	* @param Request $request (requête HTTP faite par le navigateur)
	* @param Association $association (objet association représentant l'association actuelle)
	*
	* @return Response reponse HTML (page HTML finale)
	*
	* @Route("/tableau-de-bord/accueil/{id}")
	*/
	public function tdbAccueil(Association $association): Response {
		$user = $this->getUser();
		if ($user !== $association->getUserGerant()) {
			return $this->render('erreur.html.twig',
			['messageDErreur' => "Vous (".$user->getEmail().") n'êtes pas le gérant de l'association ".$association->getNom()]);
		}

		//return new Response('Tableau de bord de '.$association->getNom());
		return $this->render('tableau-de-bord-accueil.html.twig', ['association' => $association]);
	}
}
