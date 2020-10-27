<?php

namespace Drupal\acreat_realestate_search;

/**
 * Defines events for the readme output system.
 *
 * See https://www.drupal.org/docs/creating-custom-modules/subscribe-to-and-dispatch-events.
 */
final class OutputEvents {

  /**
   * Name of the event fired when a specific output occured.
   *
   * This event allows modules to perform an action whenever a content
   * is ouput. The event listener method receives a
   * Event instance.
   *
   * @Event
   *
   * @var string
   */
  const PARSE = 'output.parse';

}
