<?php

namespace App\Controller;

/**
* importation des differentes classes qui vont nous servir ici
*/
use App\Entity\User;
use App\Entity\Association;
use App\Entity\Adhesion;

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
* classe MesAssociationsController qui va permettre d'afficher ses associations
*
* accède à la liste des associations pour un adhérent donné
* accède à la liste des associations pour un gérant donné
*/
class MesAssociationsController extends AbstractController {
    /**
    * fonction nouveau qui reçoit une requête HTTP faite par le navigateur, la traite, et renvoie une réponse HTML qui contient la page HTML finale
  	*
  	* @param Request $request (requête HTTP faite par le navigateur)
  	* @param UserPasswordEncoderInterface $passwordEncoder
  	*
  	* @return Response reponse HTML (page HTML finale)
  	*
    * @Route("/mes-associations")
    */
    public function nouveau(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

    	$adhesionRepository = $this->getDoctrine()->getRepository(Adhesion::class);
		$adhesions = $adhesionRepository->findBy(['userAdherent' => $this->getUser()]);

		$associationRepository = $this->getDoctrine()->getRepository(Association::class);
		$associationsGerees = $associationRepository->findBy(['userGerant' => $this->getUser()]);

		return $this->render('mes-associations.html.twig',
               ['adhesions' => $adhesions, 'associationsGerees' => $associationsGerees]);
    }
}
