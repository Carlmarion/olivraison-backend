<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
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
    public function createUser(User $user, ValidatorInterface $validator, UserRepository $repo )
    {
    
        // Validation des erreurs avec le bundle validator et la méthode validate() 
        $errors = $validator->validate($user);
        // Si erreurs $errorstring = le texte des erreurs -> return le texte des erreurs, sinon retourne inscription validée.
        if (count($errors) > 0) {
            // on retourne les erreurs avec le protocole de message HTTP grâce a la petite methode magique json()
         return $this->json($errors, 400);
        }
        // On cherche si un user comportant le même email existe dans la DB 
        $existingUser = $repo->findOneBy(['email' => $user->getEmail()]);
        // si cet user existe, on retourne un json() avec un message d'erreur et un message d'erreur HTTP 
        if($existingUser)
        {
            return $this->json(['error' => 'Email dejà utilisé'], 400);

        }
        //faire persist l'user en BDD
        $repo->add($user);
        // on retourne un json compprenant les informations de l'user et un message HTTP de succès. 
        return $this->json($user, 200);
        
        
    }

    #[Rest\View]
    #[Rest\Get("/users/{id}")]
    public function showUser(int $id, UserRepository $repo): Response
    {
    
        
    
      $existingUser = $repo->findOneBy(['id' => $id]);

       if(!$existingUser)
       {
            return $this->json(['erreur' => 'L\'utilisateur que vous cherchez n\'existe pas'], 404);
       }
         return $this->json($existingUser, 200) ;
      
    }

    #[Rest\View]
    #[Rest\Delete("/users/{id}")]
    public function deleteUser(int $id, UserRepository $repo): Response
    {
            
      $existingUser = $repo->findOneBy(['id' => $id]);

       if($existingUser)
       {
           $repo->remove($existingUser);
       }
        return $this->json("success", 200) ;
      
    }

}
