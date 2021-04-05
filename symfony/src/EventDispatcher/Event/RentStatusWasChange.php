<?php
/**
 * User: Oscar Sanchez
 * Date: 6/3/21
 */

namespace App\EventDispatcher\Event;


use App\EventDispatcher\Event;
use App\Service\DTO\RentChangeStatusDTO;

class RentStatusWasChange extends Event
{
    /**
     * @var RentChangeStatusDTO
     */
    private RentChangeStatusDTO $rentChangeStatus;

    /**
     * SubscriberWasSend constructor.
     * @param RentChangeStatusDTO $rentChangeStatusDTO
     */
    public function __construct(RentChangeStatusDTO $rentChangeStatusDTO)
    {
        $this->rentChangeStatus = $rentChangeStatusDTO;
        parent::__construct();
    }

    /**
     * @return RentChangeStatusDTO
     */
    public function getRentChangeStatus(): RentChangeStatusDTO
    {
        return $this->rentChangeStatus;
    }


}