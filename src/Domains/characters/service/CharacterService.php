<?php

namespace Character\service;

use Character\repository\CharacterRepository;
use Helper\RequestHelper;

include_once  __DIR__ . '/../../../helper/RequestHelper.php';
include_once  __DIR__ . '/../../../constant/urlConstants.php';
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
        $data = $this->request->sendGetRequest(CHARACTERS_URL);

        foreach ($data as $character) {
            $newCharacter['name'] = $character['fullName'];
            $newCharacter['image_url'] = $character['imageUrl'];
            $slug = $character['firstName'] != "" ? strtolower($character['firstName']) : strtolower($character['lastName']);
            $id = $this->characterRepository->createCharacter($newCharacter);
            if ($id != null) {
                $this->addQuote($id, $slug);
            }
        }

        return 'created';
    }

    private function addQuote(int $characterId, string $name): void
    {
        $quotes = $this->request->sendGetRequest(QUOTES_URL . $name);
        if ($quotes != null) {
            $quotesList = $quotes[0]['quotes'];
            foreach ($quotesList as $quote) {
                $this->characterRepository->addQuote($characterId, $quote);
            }
        }
    }


    public function getAll(): array
    {
        return $this->characterRepository->getAll();
    }

    public function deleteAll(): string
    {
        $this->characterRepository->deleteAll();

        return 'deleted';
    }
}
