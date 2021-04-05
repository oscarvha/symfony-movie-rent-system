<?php
/**
 * User: Oscar Sanchez
 * Date: 6/3/21
 */

namespace App\EventDispatcher;


interface EventInterface
{
    /**
     * @return string
     */
    public function name(): string;

    /**
     * @return \DateTimeInterface
     */
    public function createdAt(): \DateTimeInterface;
}