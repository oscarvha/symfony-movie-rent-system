<?php

namespace App\EventDispatcher;

use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use App\EventDispatcher\EventAware;

class TerminateSubscriber implements EventSubscriberInterface
{
    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * @var EventStorage
     */
    private $eventStorage;

    /**
     * TerminateSubscriber constructor.
     *
     * @param EventDispatcherInterface $dispatcher
     * @param EventStorage             $eventStorage
     */
    public function __construct(EventDispatcherInterface $dispatcher, EventStorage $eventStorage)
    {
        $this->dispatcher = $dispatcher;
        $this->eventStorage = $eventStorage;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * ['eventName' => 'methodName']
     *  * ['eventName' => ['methodName', $priority]]
     *  * ['eventName' => [['methodName1', $priority], ['methodName2']]]
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::TERMINATE => 'onTerminate',
            ConsoleEvents::TERMINATE => 'onTerminate',
        ];
    }

    public function onTerminate(): void
    {
        foreach ($this->eventStorage->events() as $key => $event) {
            $this->dispatcher->dispatch(new EventAware($event), $event->name());
            $this->eventStorage->remove($key);
        }
    }
}
