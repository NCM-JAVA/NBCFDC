<?php

/**
 * @file
 * Handles counts of entity views via AJAX with minimal bootstrap.
 */

use Drupal\Core\DrupalKernel;
use Symfony\Component\HttpFoundation\Request;

// Work when this module is at web/modules/contrib/<module_name>.
chdir('../../..');
$autoloader = require_once 'autoload.php';
$kernel = DrupalKernel::createFromRequest(Request::createFromGlobals(), $autoloader, 'prod');
$kernel->boot();
$container = $kernel->getContainer();

// If empty then every role can be tracked for view.
$excluded_roles = [];
$count_entity_owner = FALSE;
$data['uid'] = filter_input(INPUT_POST, 'uid', FILTER_VALIDATE_INT);
/**
 * Regex validating alphanumeric,
 * underscore and commas which can be present when separating multiple roles.
 */
$current_user_roles = filter_input(
  INPUT_POST,
  'user_role',
  FILTER_VALIDATE_REGEXP,
  ['options' => ['regexp' => '/^[A-Za-z0-9_,]+$/']]
);

$data['user_role'] = $current_user_roles;

$data['event_type'] = filter_input(INPUT_POST, 'event_type');
if (!in_array($data['event_type'], ['view', 'download'])) {
  $data['event_type'] = 'view';
}
$data['entity_id'] = filter_input(INPUT_POST, 'entity_id');
$data['entity_type_id'] = filter_input(INPUT_POST, 'entity_type_id');
$data['path'] = filter_input(INPUT_POST, 'path');
$data['user_name'] = filter_input(INPUT_POST, 'user_name');
$data['extra_data'] = filter_input(INPUT_POST, 'extra_data');

$container->get('request_stack')->push(Request::createFromGlobals());
$container->get('usage_data.storage.entity')->recordView($data);
