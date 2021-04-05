<?php
namespace App\Entity\ValueObject;

use http\Exception\InvalidArgumentException;
use JetBrains\PhpStorm\Pure;

class RentStatus
{
    const PENDING_CONFIRM = 'rent.status.pending.confirm';
    const CONFIRM_WAIT_SEND = 'rent.status.wait_send';
    const CONFIRM_AND_SEND = 'rent.status.confirm_and_send';
    const DELIVERED = 'rent.status.delivered';
    const RETURNED_USER = 'rent.status.returned_user';
    const FINISH = 'rent.status.finish';
    const CANCELED = 'rent.status.canceled';

    const VALID_STATUS = [
        self::PENDING_CONFIRM,
        self::CONFIRM_WAIT_SEND,
        self::CONFIRM_AND_SEND,
        self::DELIVERED,
        self::RETURNED_USER,
        self::FINISH,
        self::CANCELED
    ];

    const VALID_USER_UPDATE_STATUS = [
        self::RETURNED_USER,
        self::CANCELED
    ];

    const FINISHED_STATUS = [
        self::FINISH,
        self::CANCELED
    ];

    private string $status;

    /**
     * SubscriptionStatus constructor.
     * @param $status
     */
    private function __construct(string $status , bool $byUser = false)
    {
        if($byUser) {
            $this->addByUser($status);
        } else {
            $this->add($status);
        }
    }

    /**
     * @param $status
     */
    private function add($status)
    {
        if (!$this->isValid($status)) {

            throw new InvalidArgumentException();
        }

        $this->status = $status;
    }

    public function addByUser(string $status)
    {
        if(!$this->isValidForUser($status)) {

            throw new InvalidArgumentException();
        }
    }

    /**
     * @param $status
     * @return bool
     */
    #[Pure] private function isValid($status): bool
    {
        return in_array($status, self::VALID_STATUS);
    }

    /**
     * @param string $status
     * @return bool
     */
    #[Pure] private function isValidForUser(string $status) : bool
    {
        return in_array($status,self::VALID_USER_UPDATE_STATUS);
    }

    /**
     * @return string
     */
    public function get(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return RentStatus
     */
    public static function creatByStatus(string $status): RentStatus
    {
        return new self($status);
    }

    /**
     * @param string $status
     * @return RentStatus
     */
    public static function createByUser(string $status) : RentStatus
    {
        return new self($status);
    }

}