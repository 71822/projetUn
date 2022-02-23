<?php

namespace App\Entity;

use App\Repository\UserCinemaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserCinemaRepository::class)
 */
class UserCinema
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $name_user;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $user_surname;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $mail_user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameUser(): ?string
    {
        return $this->name_user;
    }

    public function setNameUser(string $name_user): self
    {
        $this->name_user = $name_user;

        return $this;
    }

    public function getUserSurname(): ?string
    {
        return $this->user_surname;
    }

    public function setUserSurname(string $user_surname): self
    {
        $this->user_surname = $user_surname;

        return $this;
    }

    public function getMailUser(): ?string
    {
        return $this->mail_user;
    }

    public function setMailUser(string $mail_user): self
    {
        $this->mail_user = $mail_user;

        return $this;
    }
}
