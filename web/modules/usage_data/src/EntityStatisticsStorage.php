<?php

namespace Drupal\usage_data;

use Drupal\Core\Database\Connection;
use Drupal\Core\State\StateInterface;
use Drupal\usage_data\Event\RecordingViewEvent;
use Drupal\usage_data\Event\UsageDataEvents;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Entity statistics storage.
 */
class EntityStatisticsStorage implements EntityStatisticsStorageInterface {

  const TABLE_NAME = 'usage_data';

  /**
   * The database connection used.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $connection;

  /**
   * The state service.
   *
   * @var \Drupal\Core\State\StateInterface
   */
  protected $state;

  /**
   * The request stack.
   *
   * @var \Symfony\Component\HttpFoundation\RequestStack
   */
  protected $requestStack;

  /**
   * Event dispatcher.
   *
   * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
   */
  protected $eventDispatcher;

  /**
   * Constructs the entity statistics storage.
   *
   * @param \Drupal\Core\Database\Connection $connection
   *   The database connection for the node view storage.
   * @param \Drupal\Core\State\StateInterface $state
   *   The state service.
   * @param \Symfony\Component\HttpFoundation\RequestStack $request_stack
   *   The request stack.
   * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $event_dispatcher
   *   Event dispatcher.
   */
  public function __construct(Connection $connection, StateInterface $state, RequestStack $request_stack, EventDispatcherInterface $event_dispatcher) {
    $this->connection = $connection;
    $this->state = $state;
    $this->requestStack = $request_stack;
    $this->eventDispatcher = $event_dispatcher;
  }

  /**
   * {@inheritdoc}
   */
  public function recordView($data) {
    $data['count'] = 1;
    $data['timestamp'] = $this->getRequestTime();

    /**
     * Right before we dispatch our event let decode the json into an array so
     * that other module can retrieve their data and clean it up.
     */
    if (!empty($data['extra_data'])) {
      $data['extra_data'] = json_decode($data['extra_data'], TRUE);
    }
    /**
     * This allows other modules to extract the extra data for example and
     * assign it to the proper column.
     */
    $event = new RecordingViewEvent($data);
    $this->eventDispatcher->dispatch($event, UsageDataEvents::RECORD_VIEW);
    $data = $event->getData();

    // Removing extra data.
    if (isset($data['extra_data'])) {
      unset($data['extra_data']);
    }

    return (bool) $this->connection
      ->insert(self::TABLE_NAME)
      ->fields($data)
      ->execute();
  }

  /**
   * Get current request time.
   *
   * @return int
   *   Unix timestamp for current server request time.
   */
  protected function getRequestTime() {
    return $this->requestStack->getCurrentRequest()->server->get('REQUEST_TIME');
  }

}
