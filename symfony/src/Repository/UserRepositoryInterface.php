<?php

namespace App\Repository;

use App\Entity\User;

interface UserRepositoryInterface
{
    public function getAll(): array;

    /**
     * @param string $username
     *
     * @return User|null
     */
    public function findByUsername(string  $username): ?User;

    public function findByEmail(string $email): ?User;

    /**
     * @param User $user
     */
    public function save(User $user): void;

    /**
     * @param int $id
     * @return User
     */
    public function getById(int $id) : User;


}