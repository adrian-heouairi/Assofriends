<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\User;
use App\Entity\Adhesion;
use App\Entity\Association;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('jean.dupont@gmail.com');
        $user->setPrenom('Jean');
        $user->setNom('Dupont');
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'mdp'));
        $manager->persist($user);
        
        $asso = new Association();
        $asso->setNom('Projet 2021');
        $asso->setDescription('Projet de programmation');
        $asso->setPrixAdhesionMensuelle(5.50);
        $asso->setUserGerant($user);
        $asso->setFormuleActuelle(0);
        $asso->setDateFinFormule(null);
        $asso->setFormuleMoisSuivant(null);
        $manager->persist($asso);
        
        $user2 = new User();
        $user2->setEmail('didier.boursier@gmail.com');
        $user2->setPrenom('Didier');
        $user2->setNom('Boursier');
        $user2->setPassword($this->passwordEncoder->encodePassword($user, 'mdp'));
        $manager->persist($user2);
        
        // Avec cette adhésion, Didier Boursier sera adhérent de l'association « Projet 2021 »
        $adhesion = new Adhesion();
        $adhesion->setUserAdherent($user2);
        $adhesion->setAssociation($asso);
        $adhesion->setDateFin(new \DateTime());
        $adhesion->setRenouvellementAutomatique(false);
        $adhesion->setRelanceEnvoyee(false);
        $manager->persist($adhesion);
        
        $manager->flush();
    }
}
