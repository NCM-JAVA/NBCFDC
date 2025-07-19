<?php

namespace Drupal\usage_data;

/**
 * Entity statistics storage interface.
 */
interface EntityStatisticsStorageInterface {

  /**
   * Count a entity view.
   *
   * @param array $data
   *   The ID of the entity to count.
   *
   * @return bool
   *   TRUE if the entity view has been counted.
   */
  public function recordView(array $data);

}
