<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\App\Entity\User;

class UserController extends AbstractController
{
    #[Route('/users', name: 'app_user')]
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserController.php',
        ]);
    }

    #[Route('/new/users' , name: 'create_user')]
    public function createUser( ValidatoInterface $validator): Response
    {
        $user = new User();

        $errors = $validator->validate($user);

        if (count($errors) > 0) {
            $errorString = (string) $errors;

            return new Response($errorString);
        }
        return new Response("inscription validée");

        return $this->json([

        ]);
    }

}
