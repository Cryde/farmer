<?php

namespace App\Builder\Entity\Extension;

use App\Entity\Extension\Extension;
use App\Enum\Extension\ExtensionType;

class ExtensionBuilder
{
    public function build(
        string        $name,
        string        $description,
        bool          $isUpdatable,
        ExtensionType $type
    ): Extension {
        return (new Extension())
            ->setType($type)
            ->setDescription($description)
            ->setIsUpdatable($isUpdatable)
            ->setName($name);
    }
}