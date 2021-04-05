<?php


namespace App\Entity\ValueObject;

class PasswordEncoded
{
    /**
     * @var string
     */
    private $value;

    public function __construct(string $plainPassword)
    {
        $this->setPassword($plainPassword);
    }

    /**
     * @param string $plainPassword
     *
     * @return string
     */
    private function setPassword(string $plainPassword): void
    {
        $this->value = password_hash($plainPassword, PASSWORD_DEFAULT);
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->value;
    }
}