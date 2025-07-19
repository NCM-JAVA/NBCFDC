<?php

namespace Drupal\password_policy_pwned;

/**
 * A client for querying the Pwned Password API.
 */
interface PwnedPasswordsClientInterface {

  /**
   * Gets the number of occurances in HIBP.
   *
   * @param string $password
   *   The password to check.
   *
   * @return int
   *   The number of occurances of the password in breaches.
   */
  public function getOccurrences($password);

}
