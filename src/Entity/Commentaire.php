<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentaireRepository::class)]
class Commentaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $contenu;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $rating;

    #[ORM\OneToOne(inversedBy: 'commentaire', targetEntity: Livraison::class, cascade: ['persist', 'remove'])]
    private $livraison_id;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(?string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getLivraisonId(): ?Livraison
    {
        return $this->livraison_id;
    }

    public function setLivraisonId(?Livraison $livraison_id): self
    {
        $this->livraison_id = $livraison_id;

        return $this;
    }

}
