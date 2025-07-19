<?php

namespace Drupal\Tests\password_policy_pwned\Unit;

use Prophecy\PhpUnit\ProphecyTrait;
use Drupal\password_policy_pwned\Plugin\PasswordConstraint\PasswordPnwed;
use Drupal\password_policy_pwned\PwnedPasswordsClientInterface;
use Drupal\Tests\UnitTestCase;
use Drupal\user\UserInterface;

/**
 * Tests the pwned password plugin.
 *
 * @group password_policy_pwned
 * @coversDefaultClass \Drupal\password_policy_pwned\Plugin\PasswordConstraint\PasswordPnwed
 */
class PasswordPnwedTest extends UnitTestCase {

  use ProphecyTrait;

  /**
   * @covers ::validate
   */
  public function testPwned() {
    $pwnedClient = $this->prophesize(PwnedPasswordsClientInterface::class);
    $pwnedClient->getOccurrences('abnchsdu')->willReturn(1);
    $pwnedClient->getOccurrences('password')->willReturn(3730471);

    $pwned = new PasswordPnwed(['min_occurrences' => 2], NULL, [], $pwnedClient->reveal());
    $pwned->setStringTranslation($this->getStringTranslationStub());

    $user = $this->prophesize(UserInterface::class);

    $this->assertTrue($pwned->validate('abnchsdu', $user->reveal())->isValid());
    $this->assertFalse($pwned->validate('password', $user->reveal())->isValid());
  }

}
