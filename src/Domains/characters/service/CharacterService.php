<?php

namespace Character\service;

use Character\repository\CharacterRepository;
use Helper\RequestHelper;

include_once  __DIR__ . '/../../../helper/RequestHelper.php';
class CharacterService
{
    public function create(): string
    {
        $url = 'https://thronesapi.com/api/v2/Characters';
        $request = new RequestHelper();
        $data = $request->sendGetRequest($url);

        foreach ($data as $item) {
            $character['name'] = $item['fullName'];
            $character['image_url'] = $item['imageUrl'];
            $slug = $item['firstName'] != "" ? strtolower($item['firstName']) : strtolower($item['lastName']);

            $characterRepository = new CharacterRepository();
            $id = $characterRepository->createCharacter($character);
            $this->addQuote($id, $slug);
        }

        return 'created';
    }

    public function addQuote(int $characterId, string $name): void
    {

        $url = 'https://api.gameofthronesquotes.xyz/v1/character/' . $name;
        $request = new RequestHelper();

        $quotes = $request->sendGetRequest($url);
        if ($quotes != null) {
            $quotesList = $quotes[0]['quotes'];
            foreach ($quotesList as $quote) {
                $characterRepository = new CharacterRepository();
                $characterRepository->addQuote($characterId, $quote);
            }
        }
    }


    public function getAll()
    {

        $characterRepository = new CharacterRepository();
        $characterRepository->getAll();


        return 'all';
    }

    public function deleteAll(): string
    {
        $characterRepository = new CharacterRepository();
        $characterRepository->deleteAll();

        return 'deleted';
    }
}
