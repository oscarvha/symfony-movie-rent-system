<?php
/**
 * User: Oscar Sanchez
 * Date: 4/4/21
 */

namespace App\Service\DTO;


class RentUserChangeStatusDTO implements DTOInterface
{
    /**
     * @var int
     */
    private int $user;

    /**
     * @var int
     */
    private int $rent;

    /**
     * @var string
     */
    private string $newStatus;

    /**
     * RentUserChangeStatusDTO constructor.
     * @param int $user
     * @param int $rent
     * @param string $newStatus
     */
    public function __construct(int $user, int $rent, string $newStatus)
    {
        $this->user = $user;
        $this->rent = $rent;
        $this->newStatus = $newStatus;
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
    public function getRent(): int
    {
        return $this->rent;
    }

    /**
     * @return string
     */
    public function getNewStatus(): string
    {
        return $this->newStatus;
    }


}