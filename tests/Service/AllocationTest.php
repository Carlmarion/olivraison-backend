<?php

use App\Entity\User;
use App\Entity\Adresse;
use App\Entity\Livreur;
use App\Entity\Commande;
use App\Entity\Livraison;
use App\Service\Allocation;
use Zenstruck\Foundry\Factory;
use App\Repository\LivreurRepository;
use App\Tests\Factory\AdresseFactory;
use App\Tests\Factory\LivreurFactory;
use App\Repository\CommandeRepository;
use App\Tests\Factory\CommandeFactory;
use App\Repository\LivraisonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\RepositoryProxy;

class AllocationTest extends WebTestCase
{

    protected function setUp(): void
    {
        $this->commandeRepository = static::getContainer()->get(CommandeRepository::class);
        $this->livreurRepository = static::getContainer()->get(LivreurRepository::class);
        $this->livraisonRepository = static::getContainer()->get(LivraisonRepository::class);
        $this->em = static::getContainer()->get(EntityManagerInterface::class);
        $this->allocation = new Allocation($this->commandeRepository, $this->livreurRepository, $this->livraisonRepository, $this->em);
    }

    public function testDontAllocateWhenNoLivreur()
    {
        $commande = CommandeFactory::createOne();

        $this->allocation->allocate();
        $this->assertSame($commande->getLivraison(), null);
    }

    public function testItAllocatesToAnAvailableLivreur()
    {


        $commande = CommandeFactory::createOne();
        $livreur = LivreurFactory::createOne();

        $this->allocation->allocate();

        $livraisons = $livreur->getLivraisons()->toArray();

        $this->assertTrue(count($livraisons) == 1);
    }

    public function testItAllocatesEvenlyToLivreurs()
    {

        $livreurs = LivreurFactory::createMany(3);
        CommandeFactory::createMany(15);

        $this->allocation->allocate();

        foreach ($livreurs as $livreur) {
            $this->assertTrue(count($livreur->getLivraisons()) == 5);
        }
    }

    public function testItAllocatesNoMoreThanMaxLivraisons()
    {

        $livreurs = LivreurFactory::createMany(2);
        CommandeFactory::createMany(15);

        $this->allocation->allocate();

        foreach ($livreurs as $livreur) {
            $this->assertTrue(count($livreur->getLivraisons()) <= 7);
        }
    }

    public function testItAllocatesTheOldestTheNextDay()
    {
        $repository = CommandeFactory::repository();
        LivreurFactory::createOne();
        $commande = CommandeFactory::createMany(8);

        $firstCommande = $repository->first('createdAt');

        $this->allocation->allocate();

        $lastCommande = $repository->last('createdAt');


        // $commande->assertNotPersisted($lastCommande);

        $this->assertGreaterThan($lastCommande, $firstCommande);


        

    }
}
