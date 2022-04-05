<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Entity\User;
use FOS\RestBundle\Controller\Annotations as Rest;


class UserController extends AbstractController
{
    #[Rest\Get('/users')]
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserController.php',
        ]);
    }

    #[Rest\View]
    #[Rest\Post("/user")]
    #[ParamConverter("user", converter: "fos_rest.request_body")]
    public function createUser(User $user)
    {

        $errors = $this->get('validator')->validate($user);

        if (count($errors) > 0) {
            $errorString = (string) $errors;

            return new Response($errorString);
        }
        return new Response("inscription validée");

        
    }

}
