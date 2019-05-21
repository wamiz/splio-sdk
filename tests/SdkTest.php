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
final class SdkTest extends TestCase
{
    use SplioConfig;

    /**
     * Init a new Splio Object and test for it.
     */
    public function testMainObjectInstance()
    {
        $sdk = new SplioSdk($this->buildConfig());

        $this->assertTrue(is_object($sdk) && $sdk instanceof SplioSdk);
    }
}
