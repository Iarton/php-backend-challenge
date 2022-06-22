<?php

namespace Character\repository;

use Helper\RequestHelper;

include_once  __DIR__ . '/../../../helper/RequestHelper.php';

class CharacterRepository
{
    public function createCharacter($character): int
    {

        $query = "mutation CreateCharacter {\n  insert_Character(objects:" .
            "{name: \"" . $character['name'] . "\"" .
            "image_url: \"" . $character['image_url'] .
            "\"}) {\n    returning {\n      id\n    }\n  }\n}";

        $request = new RequestHelper();
        $data = $request->sendRepositoryRequest($query, "CreateCharacter");

        return  $data['data']['insert_Character']['returning'][0]['id'];
    }

    public function addQuote(int $characterId, string $quote): void
    {
        $query = "mutation CreateQuote {\n  insert_Quote(objects: {text: \"" . $quote
            . "\", character_id: " . $characterId . "}) {\n    returning {\n      id\n      text\n    }\n  }\n}\n";
        $request = new RequestHelper();
        $request->sendRepositoryRequest($query, "CreateQuote");
    }

    public function deleteAll(): void
    {
        $query = "mutation DeleteAll {\n  delete_Character(where: {id: {_gt: 0}}) {\n    affected_rows\n  }\n}\n";
        $request = new RequestHelper();
        $request->sendRepositoryRequest($query, "DeleteAll");
    }

    public function getAll(): void
    {
        $query = "{\n  Character {\n    Quotes {\n      text\n      id\n    }\n    id\n    image_url\n    name\n  }\n}\n";
        $request = new RequestHelper();
        $request->sendRepositoryRequest($query);
    }
}
