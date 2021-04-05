<?php

namespace App\Entity;


use App\Entity\ValueObject\PasswordEncoded;
use App\Entity\ValueObject\Roles;
use App\Exception\NotMovieStockForRentingException;
use App\Exception\UserRentDuplicateMovie;
use Doctrine\Common\Collections\ArrayCollection;


class User
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string
     */
    private string $username;

    /**
     * @var string
     */
    private string $email;

    /**
     * @var PasswordEncoded;
     */
    private PasswordEncoded $password;

    /**
     * @var Roles
     */
    private Roles $roles;


    /**
     * User constructor.
     * @param string $username
     * @param string $email
     * @param PasswordEncoded $password
     * @param Roles $roles
     */
    public function __construct(string $username, string $email, PasswordEncoded $password, ValueObject\Roles $roles)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->roles = $roles;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return PasswordEncoded
     */
    public function getPassword(): PasswordEncoded
    {
        return $this->password;
    }

    /**
     * @return Roles
     */
    public function getRoles(): Roles
    {
        return $this->roles;
    }

    /**
     * @return bool
     */
    public function isUser(): bool
    {
        return $this->roles->has(Roles::USER);
    }



}