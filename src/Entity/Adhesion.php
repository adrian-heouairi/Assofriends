<?php

namespace App\Entity;

use App\Repository\AdhesionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdhesionRepository::class)
 */
class Adhesion
{
    ///**
    // * @ORM\Id
    // * @ORM\GeneratedValue
    // * @ORM\Column(type="integer")
    // */
    //private $id;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $userAdherent;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=Association::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $association;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateFin;

    /**
     * @ORM\Column(type="boolean")
     */
    private $renouvellementAutomatique;

    /**
     * @ORM\Column(type="boolean")
     */
    private $relanceEnvoyee;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserAdherent(): ?User
    {
        return $this->userAdherent;
    }

    public function setUserAdherent(?User $userAdherent): self
    {
        $this->userAdherent = $userAdherent;

        return $this;
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

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getRenouvellementAutomatique(): ?bool
    {
        return $this->renouvellementAutomatique;
    }

    public function setRenouvellementAutomatique(bool $renouvellementAutomatique): self
    {
        $this->renouvellementAutomatique = $renouvellementAutomatique;

        return $this;
    }

    public function getRelanceEnvoyee(): ?bool
    {
        return $this->relanceEnvoyee;
    }

    public function setRelanceEnvoyee(bool $relanceEnvoyee): self
    {
        $this->relanceEnvoyee = $relanceEnvoyee;

        return $this;
    }
}
