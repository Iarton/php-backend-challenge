<?php

namespace Character\repository;

use Helper\RequestHelper;

include_once  __DIR__ . '/../../../helper/RequestHelper.php';

class CharacterRepository
{
    private $request;

    public function __construct()
    {
        $this->request = new RequestHelper();
    }

    public function createCharacter($character): ?int
    {
        $query = "mutation CreateCharacter {\n  insert_Character(objects:" .
            "{name: \"" . $character['name'] . "\"" .
            "image_url: \"" . $character['image_url'] .
            "\"}) {\n    returning {\n      id\n    }\n  }\n}";

        $data = $this->request->sendRepositoryRequest($query, "CreateCharacter");
        if (array_key_exists('data', $data)) {
            return $data['data']['insert_Character']['returning'][0]['id'];
        }
        sleep(5);
        return null;
    }

    public function addQuote(int $characterId, string $quote): void
    {
        $query = "mutation CreateQuote {\n  insert_Quote(objects: {text: \"" . $quote
            . "\", character_id: " . $characterId . "}) {\n    returning {\n      id\n      text\n    }\n  }\n}\n";
        $this->request->sendRepositoryRequest($query, "CreateQuote");
    }

    public function deleteAll(): void
    {
        $query = "mutation DeleteAll {\n  delete_Character(where: {id: {_gt: 0}}) {\n    affected_rows\n  }\n}\n";
        $this->request->sendRepositoryRequest($query, "DeleteAll");
    }

    public function getAll(): array
    {
        $query = "{\n  Character {\n    Quotes {\n      text\n      id\n    }\n    id\n    image_url\n    name\n  }\n}\n";
        return $this->request->sendRepositoryRequest($query);
    }
}
