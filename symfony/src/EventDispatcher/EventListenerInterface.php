<?php
/**
 * User: Oscar Sanchez
 * Date: 6/3/21
 */

namespace App\EventDispatcher;


interface EventListenerInterface
{
    public function handle(EventAware $eventAware): void;
}