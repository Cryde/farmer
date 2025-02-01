<?php

namespace App\Procedure\Game\Initialization;

use App\Builder\Entity\Extension\ExtensionBuilder;
use App\Builder\Entity\Seed\SeedBuilder;
use App\Enum\Extension\ExtensionType;
use App\Factory\Transaction\MooCurrencyFactory;
use Brick\Money\Money;
use Doctrine\ORM\EntityManagerInterface;

readonly class InitializationProcedure
{
    public function __construct(
        private ExtensionBuilder       $extensionBuilder,
        private SeedBuilder            $seedBuilder,
        private EntityManagerInterface $entityManager
    ) {
    }

    public function addBaseExtensions(): void
    {
        $warehouse = $this->extensionBuilder->build('Warehouse', 'Place were you store stuff', true, ExtensionType::Warehouse);
        $field = $this->extensionBuilder->build('Field', 'A little field where you can plan seeds', true, ExtensionType::Field);
        $solarPanel = $this->extensionBuilder->build('Solar Panel', 'It provide energy for your farm', false, ExtensionType::SolarPanel);
        $robotCharger = $this->extensionBuilder->build('Robot Charger', 'A basic robot charger', true, ExtensionType::RobotCharger);
        $transformer = $this->extensionBuilder->build('Transformer', 'Place where you can transform food in other type of food', true, ExtensionType::Transformer);
        $this->entityManager->persist($warehouse);
        $this->entityManager->persist($field);
        $this->entityManager->persist($solarPanel);
        $this->entityManager->persist($robotCharger);
        $this->entityManager->persist($transformer);
        $this->entityManager->flush();
    }

    public function addSeeds(): void
    {
        $currency = MooCurrencyFactory::create();
        $seed1 = $this->seedBuilder->build("Tomato", "TOMATO", Money::ofMinor(1000, $currency), Money::ofMinor(1500, $currency));
        $seed2 = $this->seedBuilder->build("Carrot", "CARROT", Money::ofMinor(500, $currency), Money::ofMinor(2000, $currency));
        $seed3 = $this->seedBuilder->build("Pea", "PEA", Money::ofMinor(800, $currency), Money::ofMinor(1200, $currency));
        $seed4 = $this->seedBuilder->build("Cauliflower", "CAULIFLOWER", Money::ofMinor(1200, $currency), Money::ofMinor(1800, $currency));
        $seed5 = $this->seedBuilder->build("Pumpkin", "PUMPKIN", Money::ofMinor(1500, $currency), Money::ofMinor(1900, $currency));
        $seed6 = $this->seedBuilder->build("Potato", "POTATO", Money::ofMinor(700, $currency), Money::ofMinor(1400, $currency));
        $seed7 = $this->seedBuilder->build("Onion", "ONION", Money::ofMinor(900, $currency), Money::ofMinor(1600, $currency));
        $seed8 = $this->seedBuilder->build("Garlic", "GARLIC", Money::ofMinor(600, $currency), Money::ofMinor(1100, $currency));
        $seed9 = $this->seedBuilder->build("Bell Pepper", "BELL_PEPPER", Money::ofMinor(1100, $currency), Money::ofMinor(1700, $currency));
        $seed10 = $this->seedBuilder->build("Soy", "SOY", Money::ofMinor(1300, $currency), Money::ofMinor(2000, $currency));
        $seed11 = $this->seedBuilder->build("Cucumber", "CUCUMBER", Money::ofMinor(800, $currency), Money::ofMinor(1400, $currency));
        $seed12 = $this->seedBuilder->build("Zucchini", "ZUCCHINI", Money::ofMinor(1000, $currency), Money::ofMinor(1800, $currency));
        $seed13 = $this->seedBuilder->build("Eggplant", "EGGPLANT", Money::ofMinor(700, $currency), Money::ofMinor(1300, $currency));
        $seed14 = $this->seedBuilder->build("Turnip", "TURNIP", Money::ofMinor(500, $currency), Money::ofMinor(900, $currency));
        $seed15 = $this->seedBuilder->build("Strawberry", "STRAWBERRY", Money::ofMinor(1500, $currency), Money::ofMinor(1900, $currency));
        $this->entityManager->persist($seed1);
        $this->entityManager->persist($seed2);
        $this->entityManager->persist($seed3);
        $this->entityManager->persist($seed4);
        $this->entityManager->persist($seed5);
        $this->entityManager->persist($seed6);
        $this->entityManager->persist($seed7);
        $this->entityManager->persist($seed8);
        $this->entityManager->persist($seed9);
        $this->entityManager->persist($seed10);
        $this->entityManager->persist($seed11);
        $this->entityManager->persist($seed12);
        $this->entityManager->persist($seed13);
        $this->entityManager->persist($seed14);
        $this->entityManager->persist($seed15);
        $this->entityManager->flush();
    }
}