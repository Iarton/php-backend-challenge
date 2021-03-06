<?php

namespace TickX\Challenge\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Character\service\CharacterService;

include_once  __DIR__ . '/../../Domains/characters/service/CharacterService.php';

class getAllCharactersCommand extends Command
{
    protected function configure()
    {
        $this->setName('getAll');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $characterService = new CharacterService();
        $allCharacters = $characterService->getAll();
        foreach ($allCharacters['data']['Character'] as $character) {
            echo "\nName: " . $character['name'];
            echo "\nImage Url: " . $character['image_url'];
            echo "\nQuotes(" . sizeof($character['Quotes']) . " in total): \n";
            foreach ($character['Quotes'] as $quote) {
                echo "\t'" . $quote['text'] . "'";
                echo "\n";
            }
            echo "\n";
        };
        $output->writeln("\nEnd\n");

        return 0;
    }
}
