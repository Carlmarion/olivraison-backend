<?php

namespace App\Service;

use App\Entity\Commande;
use App\Entity\Livreur;
use App\Entity\Livraison;
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
    private $em;

   public function __construct(CommandeRepository $commandeRepository, LivreurRepository $livreurRepository, LivraisonRepository $livraisonRepository, EntityManagerInterface $em)
   {
        $this->commandeRepository = $commandeRepository;
        $this->livreurRepository = $livreurRepository;
        $this->livraisonRepository = $livraisonRepository;
        $this->em = $em;
        
   }


   public function allocate(): void
   {

       $unallocatedCommands = $this->commandeRepository->findBy(['livraison' => null], ['createdAt' => 'ASC']);
       $livreurs = $this->livreurRepository->findAll();
       $numberOfLivreurs = count($livreurs);
       if($numberOfLivreurs == 0)
       {
          return; 
       }

       $availableLivreurs = $livreurs;

       
       while(!empty($availableLivreurs) && !empty($unallocatedCommands))
       {

         foreach ($availableLivreurs as $key => $livreur) {
            if(empty($unallocatedCommands))
            {
               break;
            } 
            if($livreur->getLivraisonsCount()>=7)
            {
               unset($availableLivreurs[$key]);
               continue;
            }
      

         $command = array_shift($unallocatedCommands);
         $this->allocateLivraisonToLivreur($livreur, $command);
         
      }
   }
   }


   private function allocateLivraisonToLivreur(Livreur $livreur, Commande $command): Livraison
   {
      $em = $this->em;
      $demain = new DateTime('tomorrow');
      $livraison = new Livraison();
      $livraison->setDateLivraison($demain);

      $livraison->setCommande($command);
      $livreur->addLivraison($livraison);
      $this->livraisonRepository->add($livraison);
      $em->persist($livraison);
      $em->flush();



      return $livraison;
   }
}
