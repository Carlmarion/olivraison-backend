<?php

namespace App\Controller;
use App\Entity\Magasin;
use App\Repository\MagasinRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\Validator\ValidatorInterface;
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


    #[Rest\View]
    #[Rest\Get("/magasins/{id}")]
    public function showMagasin(int $id, MagasinRepository $repo)
    {
        // on récupère le magasin, on récupère l'email du user via la variable $user dans magasin qui nous renvoie ce qu'on veut de l'entité user
        // on retourne le magasin ainsi que l'email de l'user associé au magasin
        $magasin = $repo->findOneBy(['id' => $id]);
        $existingUser = $magasin->getUser();

        if(!$magasin)
        {
             return $this->json(['erreur' => 'Le magasin que vous cherchez n\'existe pas'], 404);
        }
          return $this->json([$magasin, $existingUser]) ;
    }

    #[Rest\View]
    #[Rest\Post("/magasin/{userId}")]
    #[ParamConverter("magasin", converter: "fos_rest.request_body")]
    public function createMagasin(Magasin $magasin, ValidatorInterface $validator, MagasinRepository $repo, User $user)
    {
        $user = $repo->getUser()->getId();
        $repo->setUser($user);
        $errors = $validator->validate($magasin);

        if(count($errors) > 0)
        {
            return $this->json($errors, 400);
        }


        return $this->json([$magasin, $user], 200);

    }


}
