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
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

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

    public function asPlot(): self
    {
        return $this->with([
            'description' => 'A little plot where you can plan seed',
            'isUpdatable' => true,
            'name' => 'Plot',
            'type' => ExtensionType::Plot,
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

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBun dle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'description' => self::faker()->text(),
            'isUpdatable' => self::faker()->boolean(),
            'name' => self::faker()->text(255),
            'type' => self::faker()->randomElement(ExtensionType::cases()),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Extension $extension): void {})
        ;
    }
}
