<?php
/**
 * User: Oscar Sanchez
 * Date: 29/3/21
 */

namespace App\Service\DTO;


use App\Entity\ValueObject\Roles;
use Symfony\Component\Validator\Constraints as Assert;

class UserCreateDTO implements DTOInterface
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
     * @Assert\Choice(choices={
     *     App\Entity\ValueObject\Roles::ADMIN,
     *     App\Entity\ValueObject\Roles::USER,
     * })
     */
    private string $role;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(max=100)
     */
    private string $plainPassword;


    /**
     * UserCreateDTO constructor.
     * @param string $username
     * @param string $email
     * @param string $role
     * @param string $plainPassword
     */
    public function __construct(string $username, string $email , string $plainPassword)
    {
        $this->username = $username;
        $this->email = $email;
        $this->role = Roles::USER;
        $this->plainPassword = $plainPassword;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @param string $role
     */
    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    /**
     * @return string
     */
    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     */
    public function setPlainPassword(string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }


}