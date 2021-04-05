<?php

namespace App\EventDispatcher\Event\Listener;

use App\EventDispatcher\EventAware;
use App\EventDispatcher\EventListenerInterface;
use App\Mail\Sender\RentChangeStatusSender;
use App\Repository\RentRepositoryInterface;

class OnRentWasChange implements EventListenerInterface
{

    /**
     * @var RentRepositoryInterface
     *
     */
    private RentRepositoryInterface $rentRepository;

    /**
     * @var RentChangeStatusSender
     */
    private RentChangeStatusSender $rentChangeStatusSender;

    /**
     * OnSubscriberSend constructor.
     * @param RentRepositoryInterface $rentRepository
     * @param RentChangeStatusSender $rentChangeStatusSender
     */
    public function __construct(RentRepositoryInterface $rentRepository ,
                                RentChangeStatusSender $rentChangeStatusSender)
    {
        $this->rentRepository = $rentRepository;
        $this->rentChangeStatusSender = $rentChangeStatusSender;
    }


    /**
     * @param EventAware $eventAware
     */
    public function handle(EventAware $eventAware): void
    {
        $rent = $this->rentRepository->getById($eventAware->event()->getNewSubscriberDTO()->getRent());
        $this->rentChangeStatusSender->sendByRent($rent);
    }
}