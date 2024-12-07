<?php

namespace App\Tests\Unit\Service\Generator;

use App\Service\Generator\AccessTokenGenerator;
use PHPUnit\Framework\TestCase;

class AccessTokenGeneratorTest extends TestCase
{
    public function test_generate(): void
    {
        $generator = new AccessTokenGenerator();

        $firstRun = $generator->generate();
        $this->assertEquals(100, mb_strlen($firstRun));
        $this->assertNotEquals('dummy-access-token', $firstRun);
        $this->assertNotEquals($firstRun, $generator->generate());
    }
}