<?php

namespace App\Enum\Extension;
enum ExtensionType: string
{
    case Warehouse = 'WAREHOUSE';
    case Plot = 'PLOT';
    case RobotCharger = 'SOLARPANEL';
    case SolarPanel = 'ROBOTCHARGER';
    case Transformer = 'TRANSFORMER';

    public static function basicExtension(): array
    {
        return [
            self::Warehouse,
            self::Plot,
            self::RobotCharger,
            self::SolarPanel,
        ];
    }
}
