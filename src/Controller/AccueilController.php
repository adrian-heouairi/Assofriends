<?php

namespace App\Controller;

/**
* importation des differents components qui vont nous servir pour cette classe
*/
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* classe AccueilController qui va permettre d'afficher l'accueil
*
* il y a une fonction qui permet d'afficher l'accueil
*/
class AccueilController extends AbstractController {
	/**
	* fonction accueil qui renvoie une réponse HTML qui contient la page HTML finale de la page d'accueil
	*
	* @return Response reponse HTML (page HTML finale)
	*
	* @Route("/", name="accueil")
	*/
	public function accueil(): Response {
		return $this->render('accueil.html.twig', []);
	}
}
