<?php

namespace App\Tests\Integration\Service\Generator;

use App\Service\Generator\FarmNameGenerator;
use App\Tests\Factory\Farm\FarmFactory;
use App\Tests\Factory\Player\FarmerFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class FarmNameGeneratorTest extends KernelTestCase
{
    use ResetDatabase, Factories;

    public function test_generate_farm_name(): void
    {
        $generator = static::getContainer()->get(FarmNameGenerator::class);

        $user = FarmerFactory::createOne(['username' => 'EXISTING']);
        $farm = FarmFactory::createOne(['relatedFarmer' => $user, 'name' => 'EXISTING-FARM-1']);

        $this->assertSame('HOWDIE-FARM-1', $generator->generateFarmName('HOWDIE'));
        $this->assertSame('EXISTING-FARM-2', $generator->generateFarmName('EXISTING'));
    }
}