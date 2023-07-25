<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class AjoutAdherent
{
    /**
     * @Assert\NotBlank
     */
    protected $nom;

    /**
     * @Assert\NotBlank
     */
    protected $prenom;

    /**
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     */
    protected $email;

    /**
     * @Assert\NotBlank
     * @Assert\Type("\DateTime")
     */
    protected $dateDeFinAdhesion;

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getDateDeFinAdhesion(): ?\DateTime
    {
        return $this->dateDeFinAdhesion;
    }

    public function setDateDeFinAdhesion(?\DateTime $dateDeFinAdhesion): void
    {
        $this->dateDeFinAdhesion = $dateDeFinAdhesion;
    }
}
