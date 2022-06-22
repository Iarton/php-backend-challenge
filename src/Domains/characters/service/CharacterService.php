<?php

namespace Character\service;

use Character\repository\CharacterRepository;
use Helper\RequestHelper;

include_once  __DIR__ . '/../../../helper/RequestHelper.php';
class CharacterService
{
    private $characterRepository;
    private $request;

    public function __construct()
    {
        $this->request = new RequestHelper();
        $this->characterRepository = new CharacterRepository();
    }

    public function create(): string
    {
        $url = 'https://thronesapi.com/api/v2/Characters';
        $data = $this->request->sendGetRequest($url);

        foreach ($data as $item) {
            $character['name'] = $item['fullName'];
            $character['image_url'] = $item['imageUrl'];
            $slug = $item['firstName'] != "" ? strtolower($item['firstName']) : strtolower($item['lastName']);
            $id = $this->characterRepository->createCharacter($character);
            $this->addQuote($id, $slug);
        }

        return 'created';
    }

    public function addQuote(int $characterId, string $name): void
    {

        $url = 'https://api.gameofthronesquotes.xyz/v1/character/' . $name;
        $quotes = $this->request->sendGetRequest($url);
        if ($quotes != null) {
            $quotesList = $quotes[0]['quotes'];
            foreach ($quotesList as $quote) {
                $this->characterRepository->addQuote($characterId, $quote);
            }
        }
    }


    public function getAll(): string
    {
        $this->characterRepository->getAll();

        return 'all';
    }

    public function deleteAll(): string
    {
        $this->characterRepository->deleteAll();

        return 'deleted';
    }
}
