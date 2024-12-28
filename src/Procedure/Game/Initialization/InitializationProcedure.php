<?php

namespace App\Procedure\Game\Initialization;
use App\Builder\Entity\Extension\ExtensionBuilder;
use App\Enum\Extension\ExtensionType;
use Doctrine\ORM\EntityManagerInterface;

readonly class InitializationProcedure
{
    public function __construct(
        private ExtensionBuilder       $extensionBuilder,
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
}