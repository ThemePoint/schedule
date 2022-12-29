<?php

declare(strict_types=1);

/**
 * Copyright (c) 2022-2022 Flexic-Systems
 *
 * @author Hendrik Legge <hendrik.legge@themepoint.de>
 *
 * @version 1.0.0
 */

namespace Flexic\Scheduler\Event\Listener;

use Flexic\Scheduler\Constants\WorkerOptions;
use Flexic\Scheduler\Event\Event\WorkerRunningEvent;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class WorkerEventListener implements EventSubscriberInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    private int $handledEvents;

    public function __construct()
    {
        $this->handledEvents = 0;
    }

    public static function getSubscribedEvents()
    {
        return [
            WorkerRunningEvent::class => 'onWorkerRun',
        ];
    }

    public function onWorkerRun(WorkerRunningEvent $event): void
    {
        $event->getWorkerConfiguration()->getLogger()->success(
            \sprintf(
                'Handle event "%s". Next run: "%s"',
                $event->getScheduleEvent()::class,
                $event->getSchedule()->getExpression()->getNextRunDate()->format('Y-m-d H:i:s'),
            ),
        );

        ++$this->handledEvents;

        $eventLimit = $event->getWorkerConfiguration()->getOption(WorkerOptions::SCHEDULE_EVENT_LIMIT);

        if (null !== $eventLimit && $eventLimit > $this->handledEvents) {
            $event->getWorkerConfiguration()->getWorker()->stop();
        }
    }
}
