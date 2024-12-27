<?php

namespace App\Builder\Api\Extension;

use App\ApiResource\Extension\Extension;
use App\Entity\Extension\Extension as ExtensionEntity;

class ExtensionBuilder
{
    public function buildFromEntity(ExtensionEntity $extensionEntity): Extension
    {
        $extension = new Extension();
        $extension->id = $extensionEntity->getType()->value;
        $extension->name = $extensionEntity->getName();
        $extension->description = $extensionEntity->getDescription();
        $extension->isUpdatable = $extensionEntity->isUpdatable();

        return $extension;
    }
}