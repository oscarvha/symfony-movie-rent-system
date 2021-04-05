<?php
/**
 * User: Oscar Sanchez
 * Date: 3/4/21
 */

namespace App\Service\DTO;


class MovieDeleteDTO implements DTOInterface
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var int
     */
    private int $user;

    /**
     * MovieDeleteDTO constructor.
     * @param int $id
     * @param int $user
     */
    public function __construct(int $id, int $user)
    {
        $this->id = $id;
        $this->user = $user;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getUser(): int
    {
        return $this->user;
    }




}