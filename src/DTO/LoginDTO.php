<?php

namespace App\DTO;

use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;




class LoginDTO
{
   
    #[Assert\NotBlank(
        message: 'ce champ ne peut être vide'
    )]
    #[Type("string")]
    private $email;

    #[Assert\NotBlank(
        message: 'ce champ ne peut être vide'
    )]
    #[Type("string")]
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