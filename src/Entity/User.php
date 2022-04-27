<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity("email", message : 'Cette email est déjà pris')]

class User implements UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message : 'Veuillez renseigner une adresse email', groups:['registration'])]
    #[Assert\Email(message : 'Cet email est déjà pris', groups:['registration'])]
    private $email;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message : 'Veuillez renseigner votre nom', groups:['registration'])]
    #[Assert\Length(min: 2, max: 45, minMessage : 'Votre prénom doit comporter au moins 2 caractères', 
    maxMessage : 'Votre prénom ne doit pas dépasser 45 caractères', groups:['registration'])]
    private $username;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message : 'Veuillez renseigner votre nom', groups:['registration'])]
    #[Assert\Length(min: 2, max: 45, minMessage : 'Votre nom doit comporter au moins 2 caractères', 
    maxMessage : 'Votre nom ne doit pas dépasser 45 caractères', groups:['registration'])]
    private $lastname;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\EqualTo(propertyPath: 'confirm_password', message: 'Veuillez saisir votre mot de passe', groups:['registration'])]
    #[Assert\Length(min: 8, minMessage : 'Votre mot de passe doit comporter au moins 8 caractères', groups:['registration'])]
    #[Assert\NotBlank(message : 'Veuillez saisir votre mot de passe', groups:['registration'])]
    private $password;

    #[Assert\EqualTo(propertyPath: 'password', message: 'Les mots de passe ne correspondent pas', groups:['registration'])]
    #[Assert\NotBlank(message : 'Veuillez confirmer votre mot de passe', groups:['registration'])]
    //Pas de orm, sinon il sera enregistré en bdd
    public $confirm_password;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getSalt(){

    }

    public function eraseCredentials(){
        
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }
}
