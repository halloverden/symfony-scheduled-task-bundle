<?php


namespace HalloVerden\ScheduledTaskBundle\Entity;


use HalloVerden\ScheduledTaskBundle\Interfaces\ScheduleInterface;
use Cron\CronExpression;
use Cron\FieldFactory;

class SimpleCronExpression extends CronExpression implements ScheduleInterface {

  const YEARLY = '0 0 1 1 *';
  const MONTHLY = '0 0 1 * *';
  const WEEKLY = '0 0 * * 0';
  const DAILY = '0 0 * * *';
  const HOURLY = '0 * * * *';
  const MINUTELY = '* * * * *';

  /**
   * @param string $expression
   * @return SimpleCronExpression
   */
  public static function create(string $expression): self {
    return new static($expression, new FieldFactory());
  }


  /**
   * @return SimpleCronExpression
   */
  public static function yearly(): self {
    return self::create(self::YEARLY);
  }

  /**
   * @return SimpleCronExpression
   */
  public static function annually(): self {
    return self::yearly();
  }

  /**
   * @return SimpleCronExpression
   */
  public static function monthly(): self {
    return self::create(self::MONTHLY);
  }

  /**
   * @return SimpleCronExpression
   */
  public static function weekly(): self {
    return self::create(self::WEEKLY);
  }

  /**
   * @return SimpleCronExpression
   */
  public static function daily(): self {
    return self::create(self::DAILY);
  }

  /**
   * @return SimpleCronExpression
   */
  public static function hourly(): self {
    return self::create(self::HOURLY);
  }

  /**
   * @return SimpleCronExpression
   */
  public static function minutely() {
    return self::create(self::MINUTELY);
  }

  public function minute(int $minute): self {
    $this->setPart(self::MINUTE, $minute);
    return $this;
  }

  public function hour(int $hour): self {
    $this->setPart(self::HOUR, $hour);
    return $this;
  }

  public function day(int $day): self {
    $this->setPart(self::DAY, $day);
    return $this;
  }

  public function month(int $month): self {
    $this->setPart(self::MONTH, $month);
    return $this;
  }

  public function weekday(int $weekday): self {
    $this->setPart(self::WEEKDAY, $weekday);
    return $this;
  }

}
