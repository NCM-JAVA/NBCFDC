<?php

namespace Drupal\Tests\password_policy_pwned\Unit;

use Drupal\password_policy_pwned\PwnedPasswordsClient;
use Drupal\Tests\UnitTestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

/**
 * Tests the pwned passwords client.
 *
 * @group password_policy_pwned
 * @coversDefaultClass \Drupal\password_policy_pwned\PwnedPasswordsClient
 */
class PwnedPasswordsClientTest extends UnitTestCase {

  /**
   * @covers ::getOccurrences
   */
  public function testGetOccurrences() {

    $body = <<<EOT
1D2DA4053E34E76F6576ED1DA63134B5E2A:2
1D72CD07550416C216D8AD296BF5C0AE8E0:10
1E2AAA439972480CEC7F16C795BBB429372:1
1E3687A61BFCE35F69B7408158101C8E414:1
1E4C9B93F3F0682250B6CF8331B7EE68FD8:3730471
EOT;
    $mock = new MockHandler([
      new Response(200, [], $body),
    ]);
    $handler = HandlerStack::create($mock);
    $httpClient = new Client(['handler' => $handler]);

    $client = new PwnedPasswordsClient($httpClient);
    $occurrences = $client->getOccurrences("password");

    $this->assertEquals(3730471, $occurrences);
  }

}
