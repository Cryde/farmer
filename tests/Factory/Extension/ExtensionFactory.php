<?php

namespace App\Tests\Factory\Extension;

use App\Entity\Extension\Extension;
use App\Enum\Extension\ExtensionType;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Extension>
 */
final class ExtensionFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Extension::class;
    }

    public function asWarehouse(): self
    {
        return $this->with([
            'description' => 'Place were you store stuff',
            'isUpdatable' => true,
            'name' => 'Warehouse',
            'type' => ExtensionType::Warehouse,
        ]);
    }

    public function asField(): self
    {
        return $this->with([
            'description' => 'A little field where you can plan seed',
            'isUpdatable' => true,
            'name' => 'Field',
            'type' => ExtensionType::Field,
        ]);
    }

    public function asSolarPanel(): self
    {
        return $this->with([
            'description' => 'It provide energy for your farm',
            'isUpdatable' => false,
            'name' => 'Solar Panel',
            'type' => ExtensionType::SolarPanel,
        ]);
    }

    public function asRobotCharger(): self
    {
        return $this->with([
            'description' => 'A basic robot charger',
            'isUpdatable' => true,
            'name' => 'Robot Charger',
            'type' => ExtensionType::RobotCharger,
        ]);
    }

    public function asTransformer(): self
    {
        return $this->with([
            'description' => 'Place where you can transform food in other type of food',
            'isUpdatable' => true,
            'name' => 'Transformer',
            'type' => ExtensionType::Transformer,
        ]);
    }

    protected function defaults(): array
    {
        return [
            'description' => self::faker()->text(),
            'isUpdatable' => self::faker()->boolean(),
            'name' => self::faker()->text(255),
            'type' => self::faker()->randomElement(ExtensionType::cases()),
        ];
    }

    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Extension $extension): void {})
        ;
    }
}
