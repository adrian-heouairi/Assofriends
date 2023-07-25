<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class EnvoiMail
{
    /**
     * @Assert\NotBlank
     */
    protected $objet;

    /**
     * @Assert\NotBlank
     */
    protected $message;


    public function getObjet(): string
    {
        return $this->objet;
    }

    public function setObjet(string $objet): void
    {
        $this->objet = $objet;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

}
