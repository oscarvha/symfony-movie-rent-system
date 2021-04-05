<?php
/**
 * User: Oscar Sanchez
 * Date: 4/4/21
 */

namespace App\Service\DTO;


class RentChangeStatusDTO implements DTOInterface
{
    /**
     * @var int
     */
    private int $rent;

    /**
     * @var string
     */
    private string $newStatus;

    /**
     * @var int
     */
    private int $user;

    /**
     * RentChangeStatusDTO constructor.
     * @param int $rent
     * @param int $user
     * @param string $newStatus
     */
    public function __construct(int $rent, int $user, string $newStatus)
    {
        $this->rent = $rent;
        $this->newStatus = $newStatus;
        $this->user = $user;
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

    /**
     * @param string $newStatus
     */
    public function setNewStatus(string $newStatus)
    {
        $this->newStatus = $newStatus;
    }

    /**
     * @return int
     */
    public function getUser(): int
    {
        return $this->user;
    }

}