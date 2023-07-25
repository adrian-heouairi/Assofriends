<?php

namespace App\Entity;

use App\Repository\AssociationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AssociationRepository::class)
 */
class Association
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     */
    private $prixAdhesionMensuelle;

    /**
     * @ORM\Column(type="integer")
     */
    private $formuleActuelle;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateFinFormule;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $formuleMoisSuivant;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $userGerant;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrixAdhesionMensuelle(): ?float
    {
        return $this->prixAdhesionMensuelle;
    }

    public function setPrixAdhesionMensuelle(float $prixAdhesionMensuelle): self
    {
        $this->prixAdhesionMensuelle = $prixAdhesionMensuelle;

        return $this;
    }

    public function getFormuleActuelle(): ?int
    {
        return $this->formuleActuelle;
    }

    public function setFormuleActuelle(int $formuleActuelle): self
    {
        $this->formuleActuelle = $formuleActuelle;

        return $this;
    }

    public function getDateFinFormule(): ?\DateTimeInterface
    {
        return $this->dateFinFormule;
    }

    public function setDateFinFormule(?\DateTimeInterface $dateFinFormule): self
    {
        $this->dateFinFormule = $dateFinFormule;

        return $this;
    }

    public function getFormuleMoisSuivant(): ?int
    {
        return $this->formuleMoisSuivant;
    }

    public function setFormuleMoisSuivant(?int $formuleMoisSuivant): self
    {
        $this->formuleMoisSuivant = $formuleMoisSuivant;

        return $this;
    }

    public function getUserGerant(): ?User
    {
        return $this->userGerant;
    }

    public function setUserGerant(?User $userGerant): self
    {
        $this->userGerant = $userGerant;

        return $this;
    }
}
