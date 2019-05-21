<?php
/**
 * Tests for data API.
 *
 * @author   Cédric Rassaert <crassaert@gmail.com>
 */

namespace Splio\Tests;

use PHPUnit\Framework\TestCase;
use \DateTime;
use Splio\SplioSdk;
use Splio\Tests\Config\SplioConfig;

/**
 * Report API class tester.
 *
 * @author Cédric Rassaert <crassaert@gmail.com>
 */
final class ReportApiTest extends TestCase
{
    use SplioConfig;

    protected $sdk;

    protected function setUp(): void
    {
        $this->sdk = new SplioSdk($this->buildConfig());
    }

    public function testReport()
    {
        $dataApi = $this->sdk->getService()->getData();

        $date = new DateTime();
        $date->modify('-3 days');

        $report = $dataApi->getReport($date);

        $this->assertIsObject($report);
    }
}
