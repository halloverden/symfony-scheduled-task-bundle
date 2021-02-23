<?php


namespace HalloVerden\ScheduledTaskBundle\Interfaces;


interface ScheduledTaskInterface {
  public function getSchedule(): ScheduleInterface;
  public function getName(): string;
}
