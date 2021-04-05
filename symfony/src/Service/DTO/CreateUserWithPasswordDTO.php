<?php

namespace App\Service\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class CreateUserWithPasswordDTO implements DTOInterface
{
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=180)
     */
    private string $username;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=180)
     * @Assert\Email()
     */
    private string $email;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(max=100)
     */
    private string $plainPassword;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Choice(choices={
     *     App\Entity\ValueObject\Roles::ADMIN,
     *     App\Entity\ValueObject\Roles::USER,
     * })
     */
    private string $role;

    /**
     * CreateUserRequest constructor.
     *
     * @param string $username
     * @param string $email
     * @param string $plainPassword
     * @param string $role
     */
    public function __construct(string $username, string $email, string $plainPassword, string $role)
    {
        $this->username = $username;
        $this->email = $email;
        $this->plainPassword = $plainPassword;
        $this->role = $role;
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
     * @return string
     */
    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }
}
