<?php

namespace App\Controller;

use DateTime;
use App\Entity\Adresse;
use App\Entity\Magasin;
use App\Entity\Commande;
use App\Repository\UserRepository;
use App\Repository\MagasinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class MagasinController extends AbstractController
{
    #[Rest\Get("/magasins")]
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/MagasinController.php',
        ]);
    }


    

    #[Rest\View( serializerGroups : ["commande", "magasin_details"])]
    #[Rest\Post("/commandes")]
    #[ParamConverter("commande", converter: "fos_rest.request_body")]
    public function createCommande(Commande $commande, UserRepository $repo, Request $request, ValidatorInterface $validator, EntityManagerInterface $em)
    {
        $errors = $validator->validate($commande); // $commande validation of the payload

        if(count($errors)>0)
        {
            return $this->json($errors, 400);
        }

        $session = $request->getSession();
        $userId = $session->get("userId");
        $user = $repo->findOneBy(["id"=>$userId]); // getting user from userId logged into the session. 

        
        $magasin = $user->getMagasin(); // get the magasin 
        $adresse = $commande->getAdresse();
        $commande->setAdresse($adresse);
        $magasin->addCommande($commande);
        $em->flush();

        //return $this->json($commande, 200);
        return $commande;
    }

    


}
