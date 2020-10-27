<?php

namespace Drupal\Drupal\readme_help\Component;

use RuntimeException;
use SplFileInfo;

/**
 * Extends \SplFileInfo to support temporary content.
 */
class FileInfoContents extends SplFileInfo {

  /**
   * Memory content file.
   *
   * @var string
   */
  protected $content;

  /**
   * Return the filename without the extension.
   *
   * @return string
   *   Filename like it was with PATHINFO_FILENAME.
   */
  public function getFilenameWithoutExtension(): string {
    $filename = $this->getFilename();

    return pathinfo($filename, \PATHINFO_FILENAME);
  }

  /**
   * Set the content of the file in memory.
   *
   * @return self
   *   The object.
   */
  public function setContents(string $content) : self {
    $this->content = $content;

    return $this;
  }

  /**
   * Returns the contents in memory.
   *
   * @return string
   *   The contents of the file
   *
   * @throws \RuntimeException
   */
  public function getContents() : string {
    if (!$this->content) {
      $this->content = $this->getOriginalContents();
    }

    return $this->content;
  }

  /**
   * Returns the contents of the file.
   *
   * @return string
   *   The contents of the file
   *
   * @throws \RuntimeException
   */
  public function getOriginalContents() : string {
    set_error_handler(function ($type, $msg) use (&$error) {
      $error = $msg;
    });
    $content = file_get_contents($this->getPathname());
    restore_error_handler();
    if (FALSE === $content) {
      throw new RuntimeException($error);
    }
    return $content;
  }

  /**
   * Write contents in file.
   *
   * @return self
   *   The object.
   *
   * @throws \RuntimeException
   */
  public function save(int $flags = 0) {
    set_error_handler(function ($type, $msg) use (&$error) {
      $error = $msg;
    });
    $result = file_put_contents($this->getPathname(), $this->getContents(), $flags);
    restore_error_handler();
    if (FALSE === $result) {
      throw new RuntimeException($error);
    }

    return $this;
  }

}
