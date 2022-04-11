<?php

namespace App\Service;

use Exception;
use App\Entity\User;
use App\DTO\LoginDTO;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityException extends Exception
{

}



class Security
{
    private $repo;

    public function __construct(UserRepository $repository )
    {
        $this->repo = $repository;
    }

    public function login(LoginDTO $login): ?User
    {
       
        $user = $this->repo->findOneBy(['email' => $login->getEmail()]);

        if(!$user)
        {
            throw new SecurityException('Utilisateur non trouvé');
        }

        $plainPassword = $login->getPassword();
        $hashedPassword = $user->getPassword();
        $isPasswordVerified = password_verify($plainPassword, $hashedPassword);

        if(!$isPasswordVerified)
        {
            throw new SecurityException('Le mot de passe ne correspond pas à celui associé à votre compte');
        }
        return ($user);
    }
}

?>