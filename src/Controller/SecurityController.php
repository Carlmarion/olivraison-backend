<?php

namespace App\Controller;

use App\DTO\LoginDTO;
use App\Service\Security;
use App\Repository\UserRepository;
use App\Service\SecurityException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use phpDocumentor\Reflection\Types\Void_;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class SecurityController extends AbstractController
{
    private $repo;

    public function __construct(UserRepository $repository )
    {
        $this->repo = $repository;
    }
    
    #[Rest\View]
    #[Rest\Post("/login")]
    #[ParamConverter("login", converter: "fos_rest.request_body")]
    public function login( LoginDTO $login, ValidatorInterface $validator, Security $security ,Request $request)
    {
        // D'abord on valide le payload login (password DB = password login)
        $errors = $validator->validate($login);
        
        if (count($errors) > 0) 
        {
           
         return $this->json($errors, 400);
        }

        $email = $login->getEmail();
        //Try/catch pour les exceptions
        try // Dans le try on effectue le login, on recupere l'id de l'user on request la session, on set la session et on return l'user loggé avec un http 200
        {
            $user = $security->login($login); // on enregistre l'user dans variable $user en appelant la méthode login
            $id = $user->getId();
            $session = $request->getSession();
            $session->set('userId', $id); // Dans Postman, l'id sera indiqué grâce à cette ligne. 
            return $this->json($user, 200);

        }catch(SecurityException $e){
            return $this->json($e->getMessage(),403);  
        }


    }
    #[Rest\Post("/logout")]
    public function logout(Request $request)
    {
            
            $session = $request->getSession();
            $session->clear();

            return $this->json('deconnecté avec succès!', 200);
        
    }


        
}
