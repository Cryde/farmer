<?php

namespace App\Command\Game;

use App\Procedure\Game\Initialization\InitializationProcedure;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'game:init',
    description: 'Initialize the game from 0',
)]
class GameInitCommand extends Command
{
    public function __construct(
        private readonly InitializationProcedure $initializationProcedure,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // EXTENSIONS
        $this->initializationProcedure->addBaseExtensions();

        // todo : SEEDS

        return Command::SUCCESS;
    }
}
