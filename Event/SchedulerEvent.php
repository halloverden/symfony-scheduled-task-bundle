<?php


namespace HalloVerden\ScheduledTaskBundle\Event;


use HalloVerden\ScheduledTaskBundle\Interfaces\ScheduledTaskInterface;
use Symfony\Contracts\EventDispatcher\Event;

class SchedulerEvent extends Event {
  const START = 'scheduler.start';
  const START_TASK = 'scheduler.task.start';
  const END_TASK = 'scheduler.task.end';
  const SKIP_TASK = 'scheduler.task.skip';
  const END = 'scheduler.end';

  /**
   * @var ScheduledTaskInterface|null
   */
  private $task;

  /**
   * SchedulerEvent constructor.
   * @param ScheduledTaskInterface|null $task
   */
  public function __construct(?ScheduledTaskInterface $task = null) {
    $this->task = $task;
  }

  /**
   * @return ScheduledTaskInterface|null
   */
  public function getTask(): ?ScheduledTaskInterface {
    return $this->task;
  }

  /**
   * @param ScheduledTaskInterface|null $task
   * @return SchedulerEvent
   */
  public function setTask(?ScheduledTaskInterface $task): self {
    $this->task = $task;
    return $this;
  }

}
