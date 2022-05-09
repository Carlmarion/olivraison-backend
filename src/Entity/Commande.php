<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Exclude;
use Symfony\Config\JmsSerializerConfig;


#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;


    #[ORM\OneToOne(targetEntity: Adresse::class, cascade: ["persist", "remove"])]
    #[ORM\JoinColumn(nullable: false)]
    private $adresse;

    #[ORM\Column(type: 'datetime_immutable')]
    private $updatedAt;

    #[ORM\Column(type: 'datetime_immutable')]
    private $createdAt;

    #[ORM\ManyToOne(targetEntity: Magasin::class, inversedBy: 'commandes')]
    #[Exclude()]
    private $magasin;

    #[ORM\OneToOne(inversedBy: 'commande', targetEntity: Livraison::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: true)]
    private $livraison;

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function updateTimeStamps(): void
    {
        $this->setUpdatedAt(new \DateTimeImmutable("now"));    
    if ($this->getCreatedAt() === null) {
        $this->setCreatedAt(new \DateTimeImmutable('now'));
    }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdresse(): Adresse
    {
        return $this->adresse;
    }

    public function setAdresse(Adresse $adresse): self
    {
        $this->adresse = $adresse;
        
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

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

    public function getLivraison(): ?Livraison
    {
        return $this->livraison;
    }

    public function setLivraison(?Livraison $livraison): self
    {
        $this->livraison = $livraison;

        return $this;
    }


}
