<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class LoginDTO
{
   
    #[Assert\NotBlank(
        message: 'ce champ ne peut être vide'
    )]
    private $email;

    #[Assert\NotBlank(
        message: 'ce champ ne peut être vide'
    )]
    private $password;
    


    public function setEmail(string $email): self
    {
        
        $this->email = $email;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setPassword(string $password): self
    {
        
        $this->password = $password;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

}


?>