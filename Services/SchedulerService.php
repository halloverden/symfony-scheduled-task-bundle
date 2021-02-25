<?php


namespace HalloVerden\ScheduledTaskBundle\Services;


use HalloVerden\ScheduledTaskBundle\Event\SchedulerEvent;
use HalloVerden\ScheduledTaskBundle\Interfaces\ScheduledTaskInterface;
use HalloVerden\ScheduledTaskBundle\Interfaces\SchedulerServiceInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class SchedulerService implements SchedulerServiceInterface {

  /**
   * @var iterable
   */
  private $tasks;

  /**
   * @var EventDispatcherInterface
   */
  private $dispatcher;

  /**
   * @var SchedulerEvent
   */
  private $event;

  /**
   * @var MessageBusInterface
   */
  private $messageBus;

  /**
   * SchedulerService constructor.
   * @param iterable $tasks
   * @param EventDispatcherInterface $dispatcher
   * @param MessageBusInterface $messageBus
   */
  public function __construct(iterable $tasks, EventDispatcherInterface $dispatcher, MessageBusInterface $messageBus) {
    $this->tasks = $tasks;
    $this->dispatcher = $dispatcher;
    $this->messageBus = $messageBus;

    $this->event = new SchedulerEvent();
  }

  /**
   * @param \DateTime|null $currentTime now is used when null
   * @param string|null $timeZone
   * @throws \Exception
   */
  public function run(?\DateTime $currentTime = null, $timeZone = null, string $name = null, bool $force = false): void {
    $this->dispatch(SchedulerEvent::START);

    if ($currentTime === null) {
      $currentTime = new \DateTime();
    }

    /** @var ScheduledTaskInterface $task */
    foreach ($this->tasks as $task) {
      if ($this->shouldRun($task, $currentTime, $timeZone, $name, $force)) {
        $this->dispatch(SchedulerEvent::START_TASK, $task);
        $this->messageBus->dispatch($task);
        $this->dispatch(SchedulerEvent::END_TASK, $task);
      } else {
        $this->dispatch(SchedulerEvent::SKIP_TASK, $task);
      }
    }

    $this->dispatch(SchedulerEvent::END);
  }

  private function shouldRun(ScheduledTaskInterface $task, ?\DateTime $currentTime = null, $timeZone = null, string $name = null, bool $force = false) {
    if ($name !== null && $name === $task->getName() && ($force || $task->getSchedule()->isDue($currentTime, $timeZone))) {
      return true;
    }

    if ($name !== null) {
      return false;
    }

    if ($force || $task->getSchedule()->isDue($currentTime, $timeZone)) {
      return true;
    }

    return false;
  }

  /**
   * @return iterable
   */
  public function getTasks(): iterable {
    return $this->tasks;
  }

  /**
   * @param string $eventName
   * @param ScheduledTaskInterface|null $task
   */
  private function dispatch(string $eventName, ?ScheduledTaskInterface $task = null) {
    $this->event->setTask($task);
    $this->dispatcher->dispatch($this->event, $eventName);
  }

}
