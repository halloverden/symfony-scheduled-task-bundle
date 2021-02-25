<?php

namespace HalloVerden\ScheduledTaskBundle\Command;

use HalloVerden\ScheduledTaskBundle\Interfaces\AsyncTaskInterface;
use HalloVerden\ScheduledTaskBundle\Interfaces\ScheduledTaskInterface;
use HalloVerden\ScheduledTaskBundle\Interfaces\SchedulerServiceInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class HVSchedulerListCommand
 * @package HalloVerden\ScheduledTaskBundle\Command
 */
class HVSchedulerListCommand extends Command {

  /**
   * @var SchedulerServiceInterface
   */
  private $schedulerService;

  /**
   * HVSchedulerListCommand constructor.
   * @param SchedulerServiceInterface $schedulerService
   */
  public function __construct(SchedulerServiceInterface $schedulerService) {
    $this->schedulerService = $schedulerService;
    parent::__construct();
  }

  /**
   *
   */
  protected function configure(): void {
    $this->setDescription('List scheduled tasks');
  }

  /**
   * @param InputInterface $input
   * @param OutputInterface $output
   * @return int
   */
  protected function execute(InputInterface $input, OutputInterface $output): int {
    $tasks = $this->schedulerService->getTasks();
    $rows = [];

    /** @var ScheduledTaskInterface $task */
    foreach ($tasks as $task) {
      $rows[] = $this->getTaskInfo($task);
    }

    if (count($rows) < 1) {
      $output->writeln("No scheduled tasks.");
      return 0;
    }

    $table = new Table($output);
    $table->setHeaders(['name', 'class', 'next run', 'type']);
    $table->setRows($rows);
    $table->render();

    return 0;
  }

  /**
   * @param ScheduledTaskInterface $task
   * @return array
   */
  private function getTaskInfo(ScheduledTaskInterface $task): array {
    $expression = $task->getSchedule();
    $nextRun = $expression->getNextRunDate()->format('c');
    $name = $task->getName();
    $class = get_class($task);
    $type = $task instanceof AsyncTaskInterface ? 'async' : 'sync';

    return [$name, $class, $nextRun, $type];
  }
}
