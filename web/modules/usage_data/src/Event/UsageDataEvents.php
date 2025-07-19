<?php

namespace Drupal\usage_data\Event;

/**
 * Defines events for the usage data module.
 *
 * @see \Drupal\usage_data\Event\RecordingViewEvent
 */
final class UsageDataEvents {

  /**
   * Name of the event fired when recording a view into the usage data table.
   *
   * This event allows other module to alter the data just before it is
   * recorded into the table.
   *
   * @Event
   *
   * @see \Drupal\usage_data\Event\RecordingViewEvent
   * @see \Drupal\usage_data\EntityStatisticsStorage::recordView()
   *
   * @var string
   */
  const RECORD_VIEW = 'usage_data.record_view';

  /**
   * Name of the event fired when collecting extras data to be passed to ajax.
   *
   * This event allows other module to alter the extra data.
   *
   * @Event
   *
   * @see \Drupal\usage_data\Event\CollectExtraDataEvent
   * @see _usage_data_default_settings()
   *
   * @var string
   */
  const COLLECT_EXTRA_DATA = 'usage_data.collect_extras_data';

}
