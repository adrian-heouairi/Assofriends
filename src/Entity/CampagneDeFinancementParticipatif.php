<?php

namespace App\Entity;

use App\Repository\CampagneDeFinancementParticipatifRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CampagneDeFinancementParticipatifRepository::class)
 */
class CampagneDeFinancementParticipatif
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Association::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $association;

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
    private $montantRecolte;

    /**
     * @ORM\Column(type="float")
     */
    private $montantObjectif;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAssociation(): ?Association
    {
        return $this->association;
    }

    public function setAssociation(?Association $association): self
    {
        $this->association = $association;

        return $this;
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

    public function getMontantRecolte(): ?float
    {
        return $this->montantRecolte;
    }

    public function setMontantRecolte(float $montantRecolte): self
    {
        $this->montantRecolte = $montantRecolte;

        return $this;
    }

    public function getMontantObjectif(): ?float
    {
        return $this->montantObjectif;
    }

    public function setMontantObjectif(float $montantObjectif): self
    {
        $this->montantObjectif = $montantObjectif;

        return $this;
    }
}
