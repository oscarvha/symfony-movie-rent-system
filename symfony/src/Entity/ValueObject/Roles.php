<?php


namespace App\Entity\ValueObject;


use App\Exception\InvalidRoleException;
use http\Exception\InvalidArgumentException;

class Roles
{
    const ADMIN = 'ROLE_ADMIN';
    const USER = 'ROLE_USER';

    const VALID_ROLES = [
        self::ADMIN,
        self::USER
    ];

    /**
     * @var array
     */
    private $values;

    public function __construct(array $roles)
    {
        $this->values = [];

        foreach ($roles as $role) {
            $this->add($role);
        }
    }

    private function add(string $role): void
    {
        if (!$this->isValid($role)) {
            throw new InvalidArgumentException();
        }

        if (!$this->has($role)) {
            $this->values[] = $role;
        }
    }

    /**
     * @param string $role
     *
     * @return bool
     */
    public function has(string $role): bool
    {
        return in_array($role, $this->get());
    }

    /**
     * @return array
     */
    public function get(): array
    {
        return $this->values;
    }


    /**
     * @param string $role
     *
     * @return bool
     */
    public function isValid(string $role): bool
    {
        return in_array($role, self::VALID_ROLES);
    }



}