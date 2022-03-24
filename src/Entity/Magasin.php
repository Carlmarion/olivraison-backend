<?php

namespace App\Entity;

use App\Repository\MagasinRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MagasinRepository::class)]
class Magasin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;


    #[ORM\ManyToMany(targetEntity: UserMagasin::class, mappedBy: 'magasin_id')]
    private $userMagasins;

    #[ORM\OneToOne(inversedBy: 'magasin', targetEntity: Addresse::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $addresse_id;

    #[ORM\OneToMany(mappedBy: 'magasin_id', targetEntity: Commande::class, orphanRemoval: true)]
    private $commandes;

    public function __construct()
    {
        $this->userMagasins = new ArrayCollection();
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }


    /**
     * @return Collection<int, UserMagasin>
     */
    public function getUserMagasins(): Collection
    {
        return $this->userMagasins;
    }

    public function addUserMagasin(UserMagasin $userMagasin): self
    {
        if (!$this->userMagasins->contains($userMagasin)) {
            $this->userMagasins[] = $userMagasin;
            $userMagasin->addMagasinId($this);
        }

        return $this;
    }

    public function removeUserMagasin(UserMagasin $userMagasin): self
    {
        if ($this->userMagasins->removeElement($userMagasin)) {
            $userMagasin->removeMagasinId($this);
        }

        return $this;
    }

    public function getAddresseId(): ?Addresse
    {
        return $this->addresse_id;
    }

    public function setAddresseId(Addresse $addresse_id): self
    {
        $this->addresse_id = $addresse_id;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setMagasinId($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getMagasinId() === $this) {
                $commande->setMagasinId(null);
            }
        }

        return $this;
    }
}
