<?php

namespace App\Controller;
use App\Entity\Magasin;
use App\Repository\MagasinRepository;
use App\Repository\UserRepository;
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
        
        $magasin = $repo->findOneBy(['id' => $id]);
        $existingUser = $magasin->getUser();

        if(!$magasin)
        {
             return $this->json(['erreur' => 'Le magasin que vous cherchez n\'existe pas'], 404);
        }
          return $this->json([$magasin, $existingUser]) ;
    }

    #[Rest\View]
    #[Rest\Post("/magasins")]
    #[ParamConverter("magasin", converter: "fos_rest.request_body")]
    public function createMagasin(Magasin $magasin, ValidatorInterface $validator, MagasinRepository $repo, UserRepository $userRepo, Request $request)
    {
        
        $errors = $validator->validate($magasin);
        
        if(count($errors) > 0)
        {
            return $this->json($errors, 400);
        }

        $existingMagasin = $repo->findOneBy(['nom' => $magasin->getNom()]);
         
        if($existingMagasin)
        {
            return $this->json(['error' => 'Nom de magasin dejà utilisé'], 400);

        }

        $session = $request->getSession();
        $userId = $session->get('userId');
        $user = $userRepo->findOneBy(['id' => $userId]);
        $magasin->setUser($user);
        $repo->add($magasin);

        

        return $this->json([$magasin], 200);

    }
    


}
