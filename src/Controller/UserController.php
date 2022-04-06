<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;




class UserController extends AbstractController
{
    #[Rest\Get('/users')]
    public function index(Request $request): Response
    {

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserController.php',
        ]);
    }

    #[Rest\View]
    #[Rest\Post("/user")]
    #[ParamConverter("user", converter: "fos_rest.request_body")]
    public function createUser(User $user, ValidatorInterface $validator, EntityManagerInterface $manager)
    {
         
        $errors = $validator->validate($user);

        if (count([$errors])) {
            $errorString = (string) $errors;

            return new Response($errorString);
        }
            return "inscription validée";
            

       

        //faire persist l'user en BDD
        $manager->persist($user);
        $manager->flush();

        return($user);
        
    }

}
