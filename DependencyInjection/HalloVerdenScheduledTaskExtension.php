<?php


namespace HalloVerden\ScheduledTaskBundle\DependencyInjection;


use Exception;
use HalloVerden\ScheduledTaskBundle\Interfaces\ScheduledTaskInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class HalloVerdenScheduledTaskExtension extends Extension {

  /**
   * @inheritDoc
   * @throws Exception
   */
  public function load(array $configs, ContainerBuilder $container) {
    $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
    $loader->load('services.yaml');
    $container->registerForAutoconfiguration(ScheduledTaskInterface::class)
      ->addTag('hallo_verden_scheduler.scheduled_task');
  }

}
