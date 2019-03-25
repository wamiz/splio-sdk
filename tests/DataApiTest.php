<?php
/**
 * Test for data PI
 *
 * @author   Cédric Rassaert <crassaert@gmail.com>
 */

namespace Splio\Tests;

use PHPUnit\Framework\TestCase;
use Splio\SplioSdk;
use Splio\Tests\Config\SplioConfig;

/**
 * Data API class tester
 */
final class DataApiTest extends TestCase
{
    use SplioConfig;

    /**
     * Fetch all lists into current universe
     */
    public function testLists()
    {
        $sdk = new SplioSdk($this->buildConfig());

        $lists = $sdk->getServices()->getData()->getLists();
        $this->assertTrue(\is_array($lists));
    }
}
