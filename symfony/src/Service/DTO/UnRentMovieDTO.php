<?php
/**
 * User: Oscar Sanchez
 * Date: 3/4/21
 */

namespace App\Service\DTO;


class UnRentMovieDTO implements DTOInterface
{
    /**
     * @var int
     */
    private int $user;

    /**
     * @var int
     */
    private int $movie;

    /**
     * RentMovieDTO constructor.
     * @param int $user
     * @param int $movie
     */
    public function __construct(int $user, int $movie)
    {
        $this->user = $user;
        $this->movie = $movie;
    }

    /**
     * @return int
     */
    public function getUser(): int
    {
        return $this->user;
    }

    /**
     * @return int
     */
    public function getMovie(): int
    {
        return $this->movie;
    }



}