<?php


namespace HalloVerden\ScheduledTaskBundle\Interfaces;


interface SchedulerServiceInterface {
  public function run(?\DateTime $currentTime = null, $timeZone = null, string $name = null, bool $force = false): void;
  public function getTasks(): iterable;
}
