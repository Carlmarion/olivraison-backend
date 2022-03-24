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

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $date_estime;

    #[ORM\OneToOne(inversedBy: 'livraison', targetEntity: Commande::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $commande_id;

    #[ORM\ManyToOne(targetEntity: Livreur::class, inversedBy: 'livraisons')]
    #[ORM\JoinColumn(nullable: false)]
    private $livreur_id;

    #[ORM\OneToOne(mappedBy: 'livraison_id', targetEntity: Commentaire::class, cascade: ['persist', 'remove'])]
    private $commentaire;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getDateEstime(): ?\DateTimeInterface
    {
        return $this->date_estime;
    }

    public function setDateEstime(?\DateTimeInterface $date_estime): self
    {
        $this->date_estime = $date_estime;

        return $this;
    }

    public function getCommandeId(): ?Commande
    {
        return $this->commande_id;
    }

    public function setCommandeId(Commande $commande_id): self
    {
        $this->commande_id = $commande_id;

        return $this;
    }

    public function getLivreurId(): ?Livreur
    {
        return $this->livreur_id;
    }

    public function setLivreurId(?Livreur $livreur_id): self
    {
        $this->livreur_id = $livreur_id;

        return $this;
    }

    public function getCommentaire(): ?Commentaire
    {
        return $this->commentaire;
    }

    public function setCommentaire(?Commentaire $commentaire): self
    {
        // unset the owning side of the relation if necessary
        if ($commentaire === null && $this->commentaire !== null) {
            $this->commentaire->setLivraisonId(null);
        }

        // set the owning side of the relation if necessary
        if ($commentaire !== null && $commentaire->getLivraisonId() !== $this) {
            $commentaire->setLivraisonId($this);
        }

        $this->commentaire = $commentaire;

        return $this;
    }
}
