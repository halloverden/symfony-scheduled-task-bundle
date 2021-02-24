Scheduled Task Bundle
==============================
The Scheduled Task  Bundle provides a way to implement cron jobs in your Symfony application, making use of the [messenger component](https://symfony.com/doc/current/messenger.html) to execute the jobs either synchronously or asynchronously.

Installation
============
Make sure Composer is installed globally, as explained in the
[installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Applications that use Symfony Flex
----------------------------------

Open a command console, enter your project directory and execute:

```console
$ composer require halloverden/symfony-scheduled-task-bundle
```

Applications that don't use Symfony Flex
----------------------------------------

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require halloverden/symfony-scheduled-task-bundle
```

### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    HalloVerden\ScheduledTaskBundle\HalloVerdenScheduledTaskBundle::class => ['all' => true],
];
```

## Usage

- Route your messages to the transports by defining your own messenger logic in your `config/packages/messenger.yaml` file.
  Tasks that implement the `AsyncTaskInterface` are automatically routed to the `async_task` transport, while those that implement the `SyncTaskInterface` are routed to the `sync` transport.
  Enabling the `failure_transport` is recommended.
  

- Create a Task class that implements the `AsyncTaskInterface` or the `SyncTaskInterface` and define the schedule and the name for the Task:
```injectablephp
class RandomScheduledTask implements AsyncTaskInterface {

  public function getSchedule(): ScheduleInterface {
    return SimpleCronExpression::monthly()->day(23)->hour(16)->minute(25);
  }
  public function getName(): string {
    return 'random-scheduled-task';
  }
}
```
- Create a TaskHandler class for your task which will need to define an `__invoke(Taskclass $task)` method:
```injectablephp
class RandomScheduledTaskHandler implements TaskHandlerInterface {

  public function __invoke(RandomScheduledTask $task) {
    //...
  }
}
```

---

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)
