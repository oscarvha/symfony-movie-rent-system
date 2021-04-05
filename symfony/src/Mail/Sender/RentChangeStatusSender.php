<?php
/**
 * User: Oscar Sanchez
 * Date: 7/3/21
 */

namespace App\Mail\Sender;

use App\Entity\Rent;
use App\Mail\Builder\RentChangeStatusBuilder;
use App\Mail\MailSender;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class RentChangeStatusSender
{
    /**
     * @var MailSender
     */
    private $sender;

    /**
     * @var RentChangeStatusBuilder
     */
    private $builder;

    /**
     * SubscriberNewSender constructor.
     * @param MailSender $sender
     * @param RentChangeStatusBuilder $builder
     */
    public function __construct(MailSender $sender, RentChangeStatusBuilder $builder)
    {
        $this->sender = $sender;
        $this->builder = $builder;
    }

    /**
     * @param Rent $rent
     * @return int
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function sendByRent(Rent $rent) : int
    {
        $message = $this->builder->createForRent($rent);

        return $this->sender->send($message);
    }


}