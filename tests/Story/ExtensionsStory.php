<?php

namespace App\Tests\Story;

use App\Tests\Factory\Extension\ExtensionFactory;
use Zenstruck\Foundry\Story;

final class ExtensionsStory extends Story
{
    public function build(): void
    {
        ExtensionFactory::new()->asWarehouse()->create();
        ExtensionFactory::new()->asPlot()->create();
        ExtensionFactory::new()->asSolarPanel()->create();
        ExtensionFactory::new()->asRobotCharger()->create();
        ExtensionFactory::new()->asTransformer()->create();
    }
}
