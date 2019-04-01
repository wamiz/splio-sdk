<?php
/**
 * Main class test.
 *
 * @author   Cédric Rassaert <crassaert@wamiz.com>
 */

namespace Splio\Tests;

use PHPUnit\Framework\TestCase;
use Splio\SplioSdk;
use Splio\Tests\Config\SplioConfig;

/**
 * Main class tester.
 */
final class OfflineDataApiTest extends TestCase
{
    use SplioConfig;

    protected $sdk;
    protected $userCollection;

    protected function setUp(): void
    {
        $this->sdk = new SplioSdk($this->buildConfig());
    }

    protected function fillUsers(): void
    {

    }

    /**
     * Init a new Splio Object and test for it.
     */
    public function testBulkImport()
    {
        $this->fillUsers();
    }
}
