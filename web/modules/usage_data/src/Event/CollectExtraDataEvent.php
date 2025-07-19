<?php

namespace Drupal\usage_data\Event;

use Symfony\Contracts\EventDispatcher\Event;

/**
 * Event fired when collecting extra data to be passed to the ajax call.
 */
class CollectExtraDataEvent extends Event {

  /**
   * The data to be recorded.
   *
   * @var array
   */
  protected $extraData;

  /**
   * Constructs the CollectExtraDataEvent instance.
   *
   * @param array $extra_data
   *   The data to be recorded.
   */
  public function __construct(array $extra_data) {
    $this->extraData = $extra_data;
  }

  /**
   * Gets the data.
   *
   * @return array
   *   The data.
   */
  public function getExtraData() {
    return $this->extraData;
  }

  /**
   * Sets the data.
   *
   * @param array $extra_data
   *   The data.
   *
   * @return $this
   */
  public function setExtraData(array $extra_data) {
    $this->extraData = $extra_data;
    return $this;
  }

}
