<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $date_commande;

    #[ORM\ManyToOne(targetEntity: Magasin::class, inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: false)]
    private $magasin;

    #[ORM\OneToOne(targetEntity: Adresse::class, cascade: ["persist", "remove"])]
    #[ORM\JoinColumn(nullable: false)]
    private $adresseDestination;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdresse(): Adresse
    {
        return $this->adresseDestination;
    }

    public function setAdresse(Adresse $adresseDestination): self
    {
        $this->adresseDestination = $adresseDestination;
        
        return $this;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->date_commande;
    }

    public function setDateCommande(?\DateTimeInterface $date_commande): self
    {
        $this->date_commande = $date_commande;

        return $this;
    }

    public function getMagasin(): ?Magasin
    {
        return $this->magasin;
    }

    public function setMagasin(?Magasin $magasin): self
    {
        $this->magasin = $magasin;

        return $this;
    }
}
