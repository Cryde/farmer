<?php

namespace App\Tests\Story;

use App\Tests\Factory\Extension\ExtensionFactory;
use Zenstruck\Foundry\Story;

final class ExtensionsStory extends Story
{
    public function build(): void
    {
        $this->addState('warehouse', ExtensionFactory::new()->asWarehouse()->create());
        $this->addState('plot', ExtensionFactory::new()->asField()->create());
        $this->addState('solarpanel', ExtensionFactory::new()->asSolarPanel()->create());
        $this->addState('robotcharger', ExtensionFactory::new()->asRobotCharger()->create());
        $this->addState('transformer', ExtensionFactory::new()->asTransformer()->create());
    }
}
