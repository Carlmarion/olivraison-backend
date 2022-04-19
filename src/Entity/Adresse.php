<?php

namespace App\Entity;

use App\Repository\AdresseRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AdresseRepository::class)]
class Adresse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank(
        message: "ce champ ne peut être vide"
    )]
    private $numero_rue;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(
        message: "ce champ ne peut être vide"
    )]
    private $rue;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(
        message: "ce champ ne peut être vide"
    )]
    private $ville;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(
        message: "ce champ ne peut être vide"
    )]
    private $code_postal;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroRue(): ?int
    {
        return $this->numero_rue;
    }

    public function setNumeroRue(int $numero_rue): self
    {
        $this->numero_rue = $numero_rue;

        return $this;
    }

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(string $rue): self
    {
        $this->rue = $rue;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->code_postal;
    }

    public function setCodePostal(string $code_postal): self
    {
        $this->code_postal = $code_postal;

        return $this;
    }

}
