<?php

namespace Drupal\readme_help\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\Core\StringTranslation\TranslationInterface;
use Drupal\Component\Plugin\FallbackPluginManagerInterface;
use Drupal\filter\FilterPluginCollection;
use Drupal\readme_help\OutputEvents;
use Drupal\readme_help\Event\ParseOutputEvent;

/**
 * Class OutputEventsSubscriver.
 */
class OutputEventsSubscriver implements EventSubscriberInterface {

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
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[OutputEvents::PARSE] = ['parseOutput'];

    return $events;
  }

  /**
   * This method is called when the help.output.parse is dispatched.
   *
   * @param \Drupal\readme_help\Event\ParseOutputEvent $event
   *   The dispatched event.
   */
  public function parseOutput(ParseOutputEvent $event) {
    $file = $event->getFile();

    if (!$event->isParsed()) {
      switch ($file->getExtension()) {
        case ('md'):
          if ($this->moduleHandler->moduleExists('markdown')) {
            if (\Drupal::hasService('markdown')) {
              $output = \Drupal::service('markdown')->parse($file->getContents());
            }
            else {
              $collection = new FilterPluginCollection($this->filterManager, []);
              $markdown = $collection->get('markdown');
              $output = $markdown->process($file->getContents(), $this->languageManager->getCurrentLanguage()->getId());
            }
            $file->setContents($output);
            $event->setParsed(TRUE);
          }
          break;

        default:
          $file->setContents('<pre>' . $this->getContents() . '</pre>');
          break;
      }
    }
  }

}
