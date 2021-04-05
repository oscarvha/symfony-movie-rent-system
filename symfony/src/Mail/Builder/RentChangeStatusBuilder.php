<?php
/**
 * User: Oscar Sanchez
 * Date: 7/3/21
 */

namespace App\Mail\Builder;


use App\Entity\Rent;
use App\Entity\Subscriber;
use App\Mail\Body;
use App\Mail\Header;
use App\Mail\Message;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

class RentChangeStatusBuilder
{
    private const SUBJECT = 'Tu alquiler ha sido actualizado';
    private const TEMPLATE = 'mail/rent_email.html.twig';

    /**
     * @var string
     */
    private $from;

    /**
     * @var Router
     */
    private $router;

    /**
     * RentChangeStatusBuilder constructor.
     * @param string $from
     * @param Router $router
     */
    public function __construct(string $from, Router $router)
    {
        $this->from = $from;
        $this->router = $router;
    }

    public function createForRent(Rent $rent) : Message
    {
        $header = new Header($rent->getUser()->getEmail(), $this->from, self::SUBJECT);

        $body = new Body(self::TEMPLATE, [
            'rent' =>  $rent
        ]);

        return new Message($header, $body);
    }


}