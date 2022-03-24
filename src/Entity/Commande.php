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

    #[ORM\Column(type: 'datetime')]
    private $date_creation;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $titre;

    #[ORM\OneToOne(inversedBy: 'commande', targetEntity: Addresse::class, cascade: ['persist', 'remove'])]
    private $addresse_id;

    #[ORM\ManyToOne(targetEntity: Magasin::class, inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: false)]
    private $magasin_id;

    #[ORM\OneToOne(mappedBy: 'commande_id', targetEntity: Livraison::class, cascade: ['persist', 'remove'])]
    private $livraison;

   

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->date_creation;
    }

    public function setDateCreation(\DateTimeInterface $date_creation): self
    {
        $this->date_creation = $date_creation;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getAddresseId(): ?Addresse
    {
        return $this->addresse_id;
    }

    public function setAddresseId(?Addresse $addresse_id): self
    {
        $this->addresse_id = $addresse_id;

        return $this;
    }

    public function getMagasinId(): ?Magasin
    {
        return $this->magasin_id;
    }

    public function setMagasinId(?Magasin $magasin_id): self
    {
        $this->magasin_id = $magasin_id;

        return $this;
    }

    public function getLivraison(): ?Livraison
    {
        return $this->livraison;
    }

    public function setLivraison(Livraison $livraison): self
    {
        // set the owning side of the relation if necessary
        if ($livraison->getCommandeId() !== $this) {
            $livraison->setCommandeId($this);
        }

        $this->livraison = $livraison;

        return $this;
    }

}
