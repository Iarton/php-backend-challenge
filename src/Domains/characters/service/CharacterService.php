<?php

namespace Character\service;

use Character\repository\CharacterRepository;

class CharacterService
{
    public function create(): string
    {
        $client = new \GuzzleHttp\Client();
        $response =  $client->get('https://thronesapi.com/api/v2/Characters');
        $data = json_decode($response->getBody(), true);
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

        $client = new \GuzzleHttp\Client();
        $quotesResponse =  $client->get('https://api.gameofthronesquotes.xyz/v1/character/' . $name);
        $quotes = json_decode($quotesResponse->getBody(), true);
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


        return 'fim';
    }

    public function deleteAll(): string
    {
        $characterRepository = new CharacterRepository();
        $characterRepository->deleteAll();

        return 'deleted';
    }
}
