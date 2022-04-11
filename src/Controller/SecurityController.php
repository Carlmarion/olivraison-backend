<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\DTO\LoginDTO;
use App\Service\Security;
use App\Service\SecurityException;


class SecurityController extends AbstractController
{
    
    
    #[Rest\View]
    #[Rest\Post("/login")]
    #[ParamConverter("login", converter: "fos_rest.request_body")]
    public function login( LoginDTO $login,ValidatorInterface $validator, Security $security)
    {
        $errors = $validator->validate($login);

        if (count($errors) > 0) 
        {
           
         return $this->json($errors, 400);
        }
        try
        {
            $user = $security->login($login);
        }catch(SecurityException $e){
            return $this->json($e->getMessage(),403);  
        }
        
    
    
        return $this->json($user, 200);
        
        
    }
}
