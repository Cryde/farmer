<?php

namespace App\Tests\Unit\Builder\Api\Farmer;

use App\Builder\Api\Farmer\FarmerBuilder;
use App\Entity\Player\Farmer as FarmerEntity;
use PHPUnit\Framework\TestCase;

class FarmerBuilderTest extends TestCase
{
    public function test_build(): void
    {
        $farmerEntity = (new FarmerEntity())
            ->setUsername('entity_username');

        $builder = new FarmerBuilder();
        $result = $builder->buildFromEntity($farmerEntity);

        $this->assertSame('entity_username', $result->username);
        // useful if I had new property :D
        $this->assertSame([
            'username',
        ], array_keys(get_object_vars($result)));
    }
}