<?php

namespace App\Entity;

use App\Repository\AddresseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AddresseRepository::class)]
class Addresse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $pays;

    #[ORM\Column(type: 'string', length: 255)]
    private $ville;

    #[ORM\Column(type: 'string', length: 255)]
    private $rue;

    #[ORM\Column(type: 'integer')]
    private $numero_rue;

    #[ORM\Column(type: 'integer')]
    private $code_postal;

    #[ORM\OneToOne(mappedBy: 'addresse_id', targetEntity: Magasin::class, cascade: ['persist', 'remove'])]
    private $magasin;

    #[ORM\OneToOne(mappedBy: 'addresse_id', targetEntity: Commande::class, cascade: ['persist', 'remove'])]
    private $commande;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

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

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(string $rue): self
    {
        $this->rue = $rue;

        return $this;
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

    public function getCodePostal(): ?int
    {
        return $this->code_postal;
    }

    public function setCodePostal(int $code_postal): self
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    public function getMagasin(): ?Magasin
    {
        return $this->magasin;
    }

    public function setMagasin(Magasin $magasin): self
    {
        // set the owning side of the relation if necessary
        if ($magasin->getAddresseId() !== $this) {
            $magasin->setAddresseId($this);
        }

        $this->magasin = $magasin;

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
            $this->commande->setAddresseId(null);
        }

        // set the owning side of the relation if necessary
        if ($commande !== null && $commande->getAddresseId() !== $this) {
            $commande->setAddresseId($this);
        }

        $this->commande = $commande;

        return $this;
    }
}
