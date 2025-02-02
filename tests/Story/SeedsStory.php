<?php

namespace App\Tests\Story;

use App\Tests\Factory\Seed\SeedFactory;
use Zenstruck\Foundry\Story;

final class SeedsStory extends Story
{
    public function build(): void
    {
        $this->addState('tomato', SeedFactory::new()->asTomato()->create());
        $this->addState('carrot', SeedFactory::new()->asCarrot()->create());
        $this->addState('pea', SeedFactory::new()->asPea()->create());
        $this->addState('cauliflower', SeedFactory::new()->asCauliflower()->create());
        $this->addState('pumpkin', SeedFactory::new()->asPumpkin()->create());
        $this->addState('potato', SeedFactory::new()->asPotato()->create());
        $this->addState('onion', SeedFactory::new()->asOnion()->create());
        $this->addState('garlic', SeedFactory::new()->asGarlic()->create());
        $this->addState('bell_pepper', SeedFactory::new()->asBellPepper()->create());
        $this->addState('soy', SeedFactory::new()->asSoy()->create());
        $this->addState('cucumber', SeedFactory::new()->asCucumber()->create());
        $this->addState('zucchini', SeedFactory::new()->asZucchini()->create());
        $this->addState('eggplant', SeedFactory::new()->asEggplant()->create());
        $this->addState('turnip', SeedFactory::new()->asTurnip()->create());
        $this->addState('strawberry', SeedFactory::new()->asStrawberry()->create());
    }
}
