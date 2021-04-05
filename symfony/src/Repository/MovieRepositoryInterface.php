<?php
/**
 * User: Oscar Sanchez
 * Date: 2/4/21
 */

namespace App\Repository;


use App\Entity\Movie;

interface MovieRepositoryInterface
{
    public function save(Movie $movie): void;

    public function findByTitle(string $tile): ?Movie;

    public function findByReference(string $reference): ?Movie;

    public function getAll() : array;

    public function getById(int $id) : Movie;

    public function delete(Movie $movie) : void;

    public function getLast(int $limit) : array;
}