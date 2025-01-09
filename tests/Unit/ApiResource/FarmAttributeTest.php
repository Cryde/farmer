<?php

namespace App\Tests\Unit\ApiResource;
use ApiPlatform\Metadata\Get;
use App\ApiResource\Farmer\Farm;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Attribute\Groups;

class FarmAttributeTest extends TestCase
{
    public function test_has_attribute(): void
    {
        $class = new \ReflectionClass(Farm::class);
        $attributes = $class->getAttributes();

        $this->assertCount(2, $attributes);
        $this->assertSame(Get::class, $attributes[0]->name);
        $this->assertSame(Groups::class, $attributes[1]->name);
    }
}