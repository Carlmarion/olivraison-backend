<?php

namespace App\Service;

use App\Entity\Commande;
use App\Entity\Livreur;
use App\Repository\CommandeRepository;
use App\Repository\LivraisonRepository;
use App\Repository\LivreurRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;



class Allocation 
{
   private $commandeRepository;
    private $livreurRepository;
    private $livraisonRepository;

   public function __construct(CommandeRepository $commandeRepository, LivreurRepository $livreurRepository, LivraisonRepository $livraisonRepository)
   {
       $this->commandeRepository = $commandeRepository;
        $this->livreurRepository = $livreurRepository;
        $this->livraisonRepository = $livraisonRepository;
        
   }


   public function allocate(): void
   {
       $commandeRepository = $this->commandeRepository ;
       $unallocatedCommands = $commandeRepository->findBy(['livraison' => null], ['createdAt' => 'ASC']);
       $today = new DateTime('now');

      foreach($unallocatedCommands as $command){
        //first $command to be processed is the oldest
        $livreur = $this->livreurRepository->findNextAvailableLivreur($today);


      }
      print_r($livreur);
   }
}

?>