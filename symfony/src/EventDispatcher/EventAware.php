<?php
/**
 * User: Oscar Sanchez
 * Date: 5/3/21
 */

namespace App\EventDispatcher;

use Symfony\Component\EventDispatcher\GenericEvent;

class EventAware extends GenericEvent
{
    /**
     * @var EventInterface
     */
    private $event;

    /**
     * EventAware constructor.
     *
     * @param EventInterface $event
     */
    public function __construct(EventInterface $event)
    {
        $this->event = $event;
    }

    /**
     * @return EventInterface
     */
    public function event(): EventInterface
    {
        return $this->event;
    }
}