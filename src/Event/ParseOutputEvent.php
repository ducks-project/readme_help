<?php

namespace Drupal\readme_help\Event;

use Symfony\Component\EventDispatcher\Event;
use Drupal\readme_help\OutputEvents;
use Drupal\readme_help\Component\FileInfoContents;

/**
 * Event that is fired when a normaliation occured on a SearchFilter.
 */
class ParseOutputEvent extends Event {

  const EVENT_NAME = OutputEvents::PARSE;

  /**
   * The output.
   *
   * @var \Drupal\readme_help\Component\FileInfoContents
   */
  protected $file;

  /**
   * TRUE if file has already be parsed.
   *
   * @var bool
   */
  protected $parsed;

  /**
   * Constructs the object.
   *
   * @param \Drupal\readme_help\Component\FileInfoContents $file
   *   The file to work with.
   */
  public function __construct(FileInfoContents $file) {
    $this->file = $file;
  }

  /**
   * Return the file.
   *
   * @return \Drupal\readme_help\Component\FileInfoContents
   *   The file.
   */
  public function getFile() : FileInfoContents {
    return $this->file;
  }

  /**
   * Set TRUE or FALSE if file has been parsed.
   *
   * @return self
   *   The object.
   */
  public function setParsed(bool $boolean) : self {
    $this->parsed = $parsed;

    return $this;
  }

  /**
   * Return TRUE if the file has been parsed.
   *
   * @return bool
   *   The value of $parsed.
   */
  public function isParsed() : bool {
    return (bool) $this->parsed;
  }

}
