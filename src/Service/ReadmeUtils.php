<?php

namespace Drupal\readme_help\Service;

use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\readme_help\Component\FileInfoContents;
use Drupal\readme_help\Event\ParseOutputEvent;

/**
 * Helper for array.
 */
class ReadmeUtils {

  /**
   * The moduleHandler.
   *
   * @var \Drupal\Core\Extension\ModuleHandlerInterface
   */
  protected $moduleHandler;

  /**
   * Constructor.
   */
  public function __construct(
    ModuleHandlerInterface $moduleHandler
  ) {
    $this->moduleHandler = $moduleHandler;
  }

  /**
   * Return the formatted output for a Readme.
   */
  public function getFormattedReadmeOutput(string $moduleName, string $extension = 'md') : string {
    $filepath = $this->moduleHandler->getModule($moduleName)->getPath() . DIRECTORY_SEPARATOR . 'README.' . $extension;
    $file = new FileInfoContents($filepath);

    // Dispatch event.
    $event = new ParseOutputEvent($file);
    $this->eventDispatcher->dispatch(ParseOutputEvent::EVENT_NAME, $event);

    return $file->getContents();
  }

}
