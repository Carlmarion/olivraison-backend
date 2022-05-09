<?php

namespace App\Entity;

use App\Repository\LivraisonRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LivraisonRepository::class)]
class Livraison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Livreur::class, inversedBy: 'livraisons')]
    #[ORM\JoinColumn(nullable: true)]
    private $livreur;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $date_livraison;

    #[ORM\OneToOne(mappedBy: 'livraison', targetEntity: Commande::class, cascade: ['persist', 'remove'])]
    private $commande;



    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function updateTimeStamps(): void
    {    
    if ($this->getDateLivraison() === null) {
        $this->setDateLivraison(new \DateTimeImmutable('now'));
    }
    }
    

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getLivreur(): ?Livreur
    {
        return $this->livreur;
    }

    public function setLivreur(?Livreur $livreur): self
    {
        $this->livreur = $livreur;

        return $this;
    }

    public function getDateLivraison(): ?\DateTimeInterface
    {
        return $this->date_livraison;
    }

    public function setDateLivraison(?\DateTimeInterface $date_livraison): self
    {
        $this->date_livraison = $date_livraison;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        // unset the owning side of the relation if necessary
        if ($commande === null && $this->commande !== null) {
            $this->commande->setLivraison(null);
        }

        // set the owning side of the relation if necessary
        if ($commande !== null && $commande->getLivraison() !== $this) {
            $commande->setLivraison($this);
        }

        $this->commande = $commande;

        return $this;
    }

}
