<?php

namespace App\Controller;

/**
* importation des differents components qui vont nous servir pour cette classe
*/
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

/**
* importation des differentes classes qui vont nous servir ici
*/
use App\Entity\Adhesion;
use App\Entity\Association;
use App\Entity\User;
use App\Entity\AjoutAdherent;

/**
* classe TableauDeBordAjoutExcelController qui va permettre sur le tableau de bord d'ajouter un adhérent via un fichier Excel
*
* créé plusieurs objets de type : Adhesion, User et Email
* créé un formulaire avec différents champs pour uploader un fichier Excel
* remplit les données sur Excel avec les informations qui ont été rentrées dans le formulaire
* sauvegarde dans la base de données les informations des objets de type  Adhesion et User
* l'objet Email sert à envoyer un mail aux adhérents qui viennent d'être ajoutés
* envoi l'email
*/
class TableauDeBordAjoutExcelController extends AbstractController {
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
    * @Route("/tableau-de-bord/ajout-excel/{id}")
    */
    public function nouveau(Request $request, Association $association, ValidatorInterface $validator, MailerInterface $mailer): Response {
        $user = $this->getUser();
		if ($user !== $association->getUserGerant()) {
			return $this->render('erreur.html.twig',
			['messageDErreur' => "Vous (".$user->getEmail().") n'êtes pas le gérant de l'association ".$association->getNom()]);
		}


        $form = $this->createFormBuilder()
            ->add('excel', FileType::class,['label'=>'Uploader un fichier Excel .xlsx (maximum 5 Mo)',
            'mapped'=>false,'constraints'=>[new File(['maxSize'=>'5000k','mimeTypes'=>['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']])]])
            ->add('save', SubmitType::class, ['label' => 'Soumettre le fichier'])
            ->getForm();


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) { // Si l'utilisateur appelle cette page avec le bouton soumettre


            /** @var UploadedFile $fichierExcel */
            $fichierExcel = $form->get('excel')->getData();
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($fichierExcel->getPathname());
            $sheet = $spreadsheet->getActiveSheet();
            $i = 2;
            $adressesEmail = [];
            while (($nom = $sheet->getCell('A'.$i)->getValue()) && ($prenom = $sheet->getCell('B'.$i)->getValue()) && ($email = $sheet->getCell('C'.$i)->getValue()) && ($dateString = $sheet->getCell('D'.$i)->getFormattedValue())) {
                $i++;

                $date = \DateTime::createFromFormat('Y-m-d_H:i:s', $dateString . '_00:00:00');
                $ajoutAdherent = new AjoutAdherent();
                $ajoutAdherent->setNom($nom);
                $ajoutAdherent->setPrenom($prenom);
                $ajoutAdherent->setEmail($email);
                $ajoutAdherent->setDateDeFinAdhesion($date);


           $userRepository = $this->getDoctrine()->getRepository(User::class);
           $futurAdherent = $userRepository->findOneBy(['email' => $ajoutAdherent->getEmail()]);
           if ($futurAdherent === null) {
             $futurAdherent = new User();

             $futurAdherent->setNom($ajoutAdherent->getNom());
             $futurAdherent->setPrenom($ajoutAdherent->getPrenom());
             $futurAdherent->setEmail($ajoutAdherent->getEmail());
             $futurAdherent->setPassword('');
             // $futurAdherent n'aura pas de mot de passe et ne pourra donc pas se connecter
             // tant qu'il n'aura pas « claim » son compte

             $errors = $validator->validate($futurAdherent); if (count($errors) > 0) { return new Response((string)$errors); }

             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($futurAdherent);
             //$entityManager->flush(); // Normalement un seul flush() à la fin suffit
           }

           $adhesion = new Adhesion();

           $adhesion->setUserAdherent($futurAdherent);
           $adhesion->setAssociation($association);
           $adhesion->setDateFin($ajoutAdherent->getDateDeFinAdhesion());
           $adhesion->setRenouvellementAutomatique(false);
           $adhesion->setRelanceEnvoyee(false);

           $errors = $validator->validate($adhesion); if (count($errors) > 0) { return new Response((string)$errors); }

           $entityManager = $this->getDoctrine()->getManager();
           $entityManager->persist($adhesion);

           $adressesEmail[] = $futurAdherent->getEmail();
           }
           //return new Response('Compteur i : ' . $i);
           $entityManager->flush();

           $email = (new Email())
           ->from('assofriendsl3@gmail.com')
            ->bcc(...$adressesEmail)
            ->subject("Confirmation automatique d'adhésion")
            ->html("Ceci est un mail automatique pour vous confirmer que vous vous êtes bien inscrit à ".$association->getNom());

            $mailer->send($email);

          //return new Response("<html><body>L'adhérent a bien été ajouté : ".$ajoutAdherent->getEmail().'</body></html>');
          return $this->render('tableau-de-bord-ajout-excel.html.twig',
               ['message' => "Les adhérents ont bien été ajoutés", 'formulaire' => $form->createView(), 'association' => $association]);
        }

        return $this->render('tableau-de-bord-ajout-excel.html.twig',
               ['message' => null, 'formulaire' => $form->createView(), 'association' => $association]);
    }
}
