<?php


namespace HalloVerden\ScheduledTaskBundle\Interfaces;


interface ScheduleInterface {

  /**
   * @param string $currentTime
   * @param null $timeZone
   * @return bool
   */
  public function isDue($currentTime = 'now', $timeZone = null);

  /**
   * @return \DateTime
   */
  public function getNextRunDate();

  /**
   * @return \DateTime
   */
  public function getPreviousRunDate();

}
