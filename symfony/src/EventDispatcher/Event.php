<?php
/**
 * User: Oscar Sanchez
 * Date: 6/3/21
 */

namespace App\EventDispatcher;


class Event implements EventInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var \DateTimeImmutable
     */
    private $createdAt;

    /**
     * Event constructor.
     *
     * @param string $name
     * @param string $createdAt
     */
    public function __construct()
    {
        $this->setName();
        try {
            $this->createdAt = new \DateTimeImmutable();
        } catch (\Exception $e) {
            $this->createdAt = null;
        }
    }

    private function setName(): void
    {
        $parts = explode('\\', get_class($this));
        $this->name = array_pop($parts);
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return \DateTimeInterface
     */
    public function createdAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }
}