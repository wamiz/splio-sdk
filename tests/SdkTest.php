<?php 

namespace Splio\Tests;

use PHPUnit\Framework\TestCase;
use Splio\SplioSdk;

final class SdkTest extends TestCase
{
    public function testMainObjectInstance()
    {
        $sdk = new SplioSdk();
    }
}