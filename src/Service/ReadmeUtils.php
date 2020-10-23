<?php

namespace Drupal\readme_help\Service;

use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\Core\StringTranslation\TranslationInterface;
use Drupal\Component\Plugin\FallbackPluginManagerInterface;
use Drupal\filter\FilterPluginCollection;

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
   * The filterManager.
   *
   * @var \Drupal\Component\Plugin\FallbackPluginManagerInterface
   */
  protected $filterManager;

  /**
   * The languageManager.
   *
   * @var \Drupal\Core\Language\LanguageManagerInterface
   */
  protected $languageManager;

  /**
   * The translation object.
   *
   * @var \Drupal\Core\StringTranslation\TranslationInterface
   */
  protected $stringTranslation;

  /**
   * Constructor.
   */
  public function __construct(
    ModuleHandlerInterface $moduleHandler,
    FallbackPluginManagerInterface $filterManager,
    LanguageManagerInterface $languageManager,
    TranslationInterface $stringTranslation
  ) {
    $this->moduleHandler = $moduleHandler;
    $this->filterManager = $filterManager;
    $this->languageManager = $languageManager;
    $this->stringTranslation = $stringTranslation;
  }

  /**
   * Return the formatted output for a Readme.
   */
  public function getFormattedReadmeOutput(string $moduleName, string $extension = 'md') : string {
    $output = '';

    $filepath = $this->moduleHandler->getModule($moduleName)->getPath() . DIRECTORY_SEPARATOR . 'README.' . $extension;
    if (file_exists($filepath)) {
      if ($readme = file_get_contents($filepath)) {
        if ('md' === $extension && $this->moduleHandler->moduleExists('markdown')) {
          if (\Drupal::hasService('markdown')) {
            $output = \Drupal::service('markdown')->parse($output);
          }
          else {
            $collection = new FilterPluginCollection($this->filterManager, []);
            $markdown = $collection->get('markdown');
            $output = $markdown->process($readme, $this->languageManager->getCurrentLanguage()->getId());
          }
        }
        else {
          $output = '<pre>' . $readme . '</pre>';
        }
      }
    }

    return $output;
  }

}
