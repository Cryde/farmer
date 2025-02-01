<?php

namespace App\Tests\Command\Game;

use App\Repository\Extension\ExtensionRepository;
use App\Repository\Seed\SeedRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;
use Symfony\Bundle\FrameworkBundle\Console\Application;

class GameInitCommandTest extends KernelTestCase
{
    use ResetDatabase, Factories;

    public function test_execute(): void
    {
        self::bootKernel();
        $extensionRepository = static::getContainer()->get(ExtensionRepository::class);
        $seedRepository = static::getContainer()->get(SeedRepository::class);
        $application = new Application(self::$kernel);

        $this->assertCount(0, $extensionRepository->findAll());
        $command = $application->find('game:init');
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        $commandTester->assertCommandIsSuccessful();
        $this->assertCount(5, $extensionRepository->findAll());
        $this->assertCount(15, $seedRepository->findAll());

        // todo : later test the number of queries made
    }
}