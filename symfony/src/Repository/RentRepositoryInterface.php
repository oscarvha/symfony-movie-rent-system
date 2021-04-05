<?php
/**
 * User: Oscar Sanchez
 * Date: 4/4/21
 */

namespace App\Repository;


use App\Entity\Rent;

interface RentRepositoryInterface
{
    public function save(Rent $rent) :void;

    public function getByUserName(int $idUser) : array;

    public function getById(int $id): ?Rent;

    public function getAll() : array;
}