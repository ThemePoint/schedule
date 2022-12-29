🕧 PHP Schedule
----------------

PHP Schedule is a simple library for scheduling tasks in PHP.   
It is inspired by the [Laravel Scheduler](https://laravel.com/docs/scheduling) and [Symfony Messenger](https://symfony.com/doc/current/components/messenger.html).

----
### Installation

Run

```bash
composer require flexic/scheduler
```

to install `flexic/scheduler`.

----
### Setup Events to schedule

```php
class MyScheduleEvent implements \Flexic\Scheduler\Interfaces\ScheduleEventInterface
{
    public function __invoke(): void
    {
        // ... do something
    }
    
    public function configure(Flexic\Scheduler\Interfaces\ScheduleInterface $schedule): void
    {
        $schedule->cron('* * * * *');
    }
}
```

Schedule events are classes that implement the `ScheduleEventInterface`.
Inside the `configure` method, you can use the `Schedule` object to define when the event should be scheduled to run.

### Setup Schedule Worker (Console Command)

Run
```bash
php bin/schedule ./path/to/event_config.php ./path/to/event_config_1.php
```
to start the schedule worker. Worker will automatically load all events from the given config files and run them.

#### Options
| Option        |                                              Description                                               |    Format     |
|---------------|:------------------------------------------------------------------------------------------------------:|:-------------:|
| limit         | Limits the worker to the give number. Worker stops automatically if number if max Event runs exceeded. |      int      |
| timeLimit     |                              Worker stops automatically after given time.                              | int (seconds) |
| intervalLimit |                       Worker stops automatically after give amout of intervals.                        |      int      |
| memoryLimit   |                 Worker stops automatically if usage of memory exceeds the given limit.                 |  int (bytes)  |


### Setup Schedule Worker (own script)

```php
# Options for worker
$options = [];
$events = [
    new MyScheduleEvent(),
];

$worker = new \Flexic\Scheduler\Worker(
    new Flexic\Scheduler\Configuration\WorkerConfiguration($options),
    $events,
    new \Symfony\Component\EventDispatcher\EventDispatcher(),
);

$worker->start();
```

### Worker API
| Method    |                     Description                      |
|-----------|:----------------------------------------------------:|
| start()   |                  Starts the worker.                  |
| stop()    |                  Stops the worker.                   |
| restart() |        Reinitialize and restarts the worker.         |
| update()  | Update the worker and starts with new configuration. |

### Worker Lifecycle Events
| Event Name               | Description                                         |
|--------------------------|-----------------------------------------------------|
| WorkerInitializedEvent   | Executed when worker is initialized.                |
| WorkerStartEvent         | Executed when worker is started.                    |
| WorkerStopEvent          | Executed when worker is stopped.                    |
| WorkerRestartEvent       | Executed when worker is restarted.                  |
| WorkerRunStartEvent      | Executed everytime an event is started to process.  |
| WorkerRunEnvEvent        | Executed everytime an event is finished to process. |
| WorkerUpdateEvent        | Executed everytime the worker is updated.           |
| WorkerIntervalStartEvent | Executed everytime a interval is started.           |
| WorkerIntervalEndEvent   | Executed everytime a interval is finished.          |
All events are located in namespace `Flexic\Scheduler\Event\Event\<EventName>`


----
### License
This package is licensed using the GNU License.

Please have a look at [LICENSE.md](LICENSE.md).

----

### Changelog
[1.0][2022-10-05] Initial release

---

[![Donate](https://img.shields.io/badge/Donate-PayPal-blue.svg)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=Q98R2QXXMTUF6&source=url)