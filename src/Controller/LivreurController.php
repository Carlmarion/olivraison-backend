<?php

namespace App\Controller;

use App\Entity\Livreur;
use App\Repository\LivreurRepository;
use App\Repository\UserRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class LivreurController extends AbstractController
{
    #[Route('/livreur', name: 'app_livreur')]
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/LivreurController.php',
        ]);
    }


    #[Rest\View]
    #[Rest\Post("livreurs")]
    #[ParamConverter("livreur", converter: "fos_rest.request_body")]
    public function createLivreur(Livreur $livreur, LivreurRepository $livreurRepo, UserRepository $userRepo, Request $request)
    {
        
        $existingLivreur = $livreurRepo->findOneBy(["id"=> $livreur->getId()]);

        if($existingLivreur)
        {
            return $this->json(["error","Vous ne pouvez créer qu'un seul compte livreur par utilisateur!"], 400);
        }

        $session = $request->getSession();
        $userId = $session->get("userId");
        $user = $userRepo->findOneBy(['id' => $userId]);
        $livreur->setUser($user);
        $livreurRepo->add($livreur);

        return $livreur;

    }

    #[Rest\View]
    #[Rest\Get("/livreurs/{id}")]
    public function showLivreur(int $id, LivreurRepository $livreurRepo)
    {
        $livreur = $livreurRepo->findOneBy(['id' => $id]);
        $existingLivreur = $livreur->getUser();

        if(!$existingLivreur)
        {
            return $this->json(["error","le compte de livreur que vous cherchez n\'existe pas"], 400);
        }

        return $existingLivreur;
    }
}
