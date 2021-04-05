<?php

namespace App\EventDispatcher;


class EventStorage
{
    /**
     * @var self
     */
    private static $instance;

    /**
     * @var EventInterface[]
     */
    private $events;

    /**
     * EventStorage constructor.
     */
    public function __construct()
    {
        $this->events = [];
    }

    /**
     * @return EventStorage
     */
    public static function instance(): self
    {
        if (null === self::$instance) {
            static::$instance = new self();
        }

        return static::$instance;
    }

    /**
     * @return EventInterface[]
     */
    public function events(): array
    {
        return static::instance()->events;
    }

    /**
     * @param EventInterface $event
     */
    public function add(EventInterface $event): void
    {
        static::instance()->events[] = $event;
    }

    /**
     * @param int $key
     *
     * @return bool
     */
    public function has(int $key): bool
    {
        return array_key_exists($key, static::instance()->events());
    }

    /**
     * @param int $key
     */
    public function remove(int $key): void
    {
        if (static::instance()->has($key)) {
            unset(static::instance()->events[$key]);
        }
    }

    public function flush(): void
    {
        static::instance()->events = [];
    }
}
