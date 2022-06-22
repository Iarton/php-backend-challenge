<?php

namespace TickX\Challenge\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Character\service\CharacterService;

include_once  __DIR__ . '/../../Domains/characters/service/CharacterService.php';

class executeEntireFlowCommand extends Command
{
    protected function configure()
    {
        $this->setName('executeFlow');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $characterService = new CharacterService();

        $characterService->create();
        echo "created\n";

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

        $characterService->deleteAll();
        echo "deleted\n";

        $output->writeln('flow completed');

        return 0;
    }
}
