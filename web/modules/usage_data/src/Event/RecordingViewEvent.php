<?php

namespace Drupal\usage_data\Event;

use Symfony\Contracts\EventDispatcher\Event;

/**
 * Event fired when a view record data is about to be stored.
 */
final class RecordingViewEvent extends Event {

  /**
   * The data to be recorded.
   *
   * @var array
   */
  protected $data;

  /**
   * Constructs the RecordingViewEvent instance.
   *
   * @param array $data
   *   The data to be recorded.
   */
  public function __construct(array $data) {
    $this->data = $data;
  }

  /**
   * Gets the data.
   *
   * @return array
   *   The data.
   */
  public function getData() {
    return $this->data;
  }

  /**
   * Sets the data.
   *
   * @param array $data
   *   The data.
   *
   * @return $this
   */
  public function setData(array $data) {
    $this->data = $data;
    return $this;
  }

}
