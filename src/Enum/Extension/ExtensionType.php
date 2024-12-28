<?php

namespace App\Enum\Extension;
enum ExtensionType: string
{
    case Warehouse = 'WAREHOUSE';
    case Field = 'FIELD';
    case RobotCharger = 'SOLARPANEL';
    case SolarPanel = 'ROBOTCHARGER';
    case Transformer = 'TRANSFORMER';

    public static function basicExtension(): array
    {
        return [
            self::Warehouse,
            self::Field,
            self::RobotCharger,
            self::SolarPanel,
        ];
    }
}
