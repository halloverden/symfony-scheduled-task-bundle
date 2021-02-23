<?php


namespace HalloVerden\ScheduledTaskBundle\Command;


use HalloVerden\ScheduledTaskBundle\Interfaces\SchedulerServiceInterface;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class HVSchedulerRunCommand
 * @package HalloVerden\ScheduledTaskBundle\Command
 */
class HVSchedulerRunCommand extends Command {

  /**
   * @var SchedulerServiceInterface
   */
  private $schedulerService;

  /**
   * HVSRunCommand constructor.
   * @param SchedulerServiceInterface $schedulerService
   */
  public function __construct(SchedulerServiceInterface $schedulerService) {
    $this->schedulerService = $schedulerService;

    parent::__construct();
  }


  protected function configure() {
    $this->setDescription('Run scheduled tasks')
      ->addArgument('name', InputArgument::OPTIONAL, 'Name of task to run')
      ->addOption('force', null, InputOption::VALUE_OPTIONAL, 'Run even if not scheduled', false)
      ->addOption('time', 't', InputOption::VALUE_OPTIONAL, 'Simulate time this is run at');
  }

  protected function execute(InputInterface $input, OutputInterface $output) {
    $io = new SymfonyStyle($input, $output);

    $time = $input->getOption('time');

    $currentTime = null;
    if ($time !== null) {
      /** @var CarbonInterface $carbonTime */
      $carbonTime = null;
      try {
        $carbonTime = Carbon::parse($time);
      } catch (\Exception $exception) {
        $io->error('Invalid time format (see Carbon::parse() doc)');
        exit(1);
      }
      $currentTime = $carbonTime->toDateTime();
    }

    $this->schedulerService->run($currentTime, null, $input->getArgument('name') ?: null, $input->getOption('force') !== false);

    return 0;
  }

}
