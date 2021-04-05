<?php

namespace App\EventDispatcher;

class EventPublisher
{
    /**
     * @var EventPublisher
     */
    private static $instance;

    /**
     * @var EventStorage
     */
    private $eventStorage;

    /**
     * EventPublisher constructor.
     *
     * @param EventStorage $eventStorage
     */
    private function __construct(EventStorage $eventStorage)
    {
        $this->eventStorage = $eventStorage;
    }

    /**
     * @return EventPublisher
     */
    public static function instance(): EventPublisher
    {
        if (null === static::$instance) {
            static::$instance = new self(EventStorage::instance());
        }

        return static::$instance;
    }

    /**
     * @param EventInterface $event
     */
    public static function publish(EventInterface $event): void
    {
        static::instance()->eventStorage->add($event);
    }
}
