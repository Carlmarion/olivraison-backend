<?php

namespace App\Entity;

use App\Repository\LivreurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LivreurRepository::class)]
class Livreur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'array', nullable: true)]
    private $disponibilites = [];

    #[ORM\OneToOne(mappedBy: 'livreur_id', targetEntity: UserLivreur::class, cascade: ['persist', 'remove'])]
    private $userLivreur;

    #[ORM\OneToMany(mappedBy: 'livreur_id', targetEntity: Livraison::class)]
    private $livraisons;

    public function __construct()
    {
        $this->livraisons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDisponibilites(): ?array
    {
        return $this->disponibilites;
    }

    public function setDisponibilites(?array $disponibilites): self
    {
        $this->disponibilites = $disponibilites;

        return $this;
    }

    public function getUserLivreur(): ?UserLivreur
    {
        return $this->userLivreur;
    }

    public function setUserLivreur(UserLivreur $userLivreur): self
    {
        // set the owning side of the relation if necessary
        if ($userLivreur->getLivreurId() !== $this) {
            $userLivreur->setLivreurId($this);
        }

        $this->userLivreur = $userLivreur;

        return $this;
    }

    /**
     * @return Collection<int, Livraison>
     */
    public function getLivraisons(): Collection
    {
        return $this->livraisons;
    }

    public function addLivraison(Livraison $livraison): self
    {
        if (!$this->livraisons->contains($livraison)) {
            $this->livraisons[] = $livraison;
            $livraison->setLivreurId($this);
        }

        return $this;
    }

    public function removeLivraison(Livraison $livraison): self
    {
        if ($this->livraisons->removeElement($livraison)) {
            // set the owning side to null (unless already changed)
            if ($livraison->getLivreurId() === $this) {
                $livraison->setLivreurId(null);
            }
        }

        return $this;
    }
}
