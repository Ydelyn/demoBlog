<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;




/**
* @ORM\Entity(repositoryClass="App\Repository\UserRepository")
* @UniqueEntity(
* fields = {"email"},
* message = "Un compte est déja existant à cette adresse Email!"
* )
*/
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="8", minMessage="Votre mot de passe doit faire minimum 8 caractères")
     */
    private $password;

    /**
     * @Assert\EqualTo(propertyPath="password",message="Les mots de passe ne correspondent pas")
     */
    public $confirm_password;

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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    // Nous décalrons ces méthodes à vide puisque nous n'avons rien à faire de particulier
    //La eraseCredentials()méthode est uniquement destinée à nettoyer les motsde passe en texte brut éventuellement stockés
    public function eraseCredentials()
    {
    }
    // Renvoie la chaine de caractères non encodé que l'utilisateur a saisi, qui a été utilisé à l'origine pour coder le mot de passe.
    public function getSalt()
    {
    }

    // cette fonction doit renvoyer un tableau de chaine de caractères
    //Renvoie les rôles accordés à l'utilisateur.
    public function getRoles()
    {
        return ['ROLE_USER']; // utilisateur classique
    }
}
