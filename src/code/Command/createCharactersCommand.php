<?php

namespace TickX\Challenge\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Character\service\CharacterService;

include_once  __DIR__ . '/../../Domains/characters/service/CharacterService.php';

class createCharactersCommand extends Command
{
    protected function configure()
    {
        $this->setName('create');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $characterService = new CharacterService();
        $output->writeln($characterService->create());

        return 0;
    }
}
