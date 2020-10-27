<?php

namespace Drupal\readme_help\Service;

/**
 * Readme service Interface.
 */
interface ReadmeUtilsInterface {

  /**
   * Return the formatted output for a Readme.
   *
   * @param string $moduleName
   *   The module name.
   * @param string $extension
   *   The extension of README to parse.
   *
   * @return string
   *   The formatted content (as html) for the README.
   */
  public function getFormattedReadmeOutput(string $moduleName, string $extension = 'md') : string;

}
