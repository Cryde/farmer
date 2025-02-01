<?php

namespace App\ApiResource\Extension;

use ApiPlatform\Metadata\GetCollection;
use App\State\Provider\Extension\ExtensionCollectionProvider;

#[GetCollection(
    paginationEnabled: false,
    provider: ExtensionCollectionProvider::class
)]
class Extension
{
    public string $id;
    public string $name;
    public string $description;
    public bool $isUpdatable;
}