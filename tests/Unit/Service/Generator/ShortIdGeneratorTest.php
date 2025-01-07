<?php

namespace App\Tests\Unit\Service\Generator;

use App\Service\Generator\ShortIdGenerator;
use PHPUnit\Framework\TestCase;

class ShortIdGeneratorTest extends TestCase
{
    public function test_generateShortId(): void
    {
        $generator = new ShortIdGenerator();

        $this->assertSame(25, mb_strlen($generator->generateShortId()));
        $this->assertSame(100, mb_strlen($generator->generateShortId(100)));
        $this->assertSame(2, mb_strlen($generator->generateShortId(2)));
    }
}