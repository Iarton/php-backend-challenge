<?php

namespace Character\repository;

class CharacterRepository
{
    public function createCharacter($character): int
    {
        $client = new \GuzzleHttp\Client();
        $response =  $client->post('https://backend-challenge.hasura.app/v1/graphql', [
            'headers' => [
                'x-hasura-admin-secret' => 'uALQXDLUu4D9BC8jAfXgDBWm1PMpbp0pl5SQs4chhz2GG14gAVx5bfMs4I553keV',
                'content-type' => 'application/json'
            ],
            'json' => [
                'query' => "mutation CreateCharacter {\n  insert_Character(objects:" .
                    "{name: \"" . $character['name'] . "\"" .
                    "image_url: \"" . $character['image_url'] .
                    "\"}) {\n    returning {\n      id\n    }\n  }\n}",
                "operationName" => "CreateCharacter"
            ]
        ]);

        $data = json_decode($response->getBody(), true);
        return  $data['data']['insert_Character']['returning'][0]['id'];
    }

    public function addQuote(int $characterId, string $quote): void
    {
        $client = new \GuzzleHttp\Client();
        $client->post('https://backend-challenge.hasura.app/v1/graphql', [
            'headers' => [
                'x-hasura-admin-secret' => 'uALQXDLUu4D9BC8jAfXgDBWm1PMpbp0pl5SQs4chhz2GG14gAVx5bfMs4I553keV',
                'content-type' => 'application/json'
            ],
            'json' => [
                'query' => "mutation CreateQuote {\n  insert_Quote(objects: {text: \"" . $quote
                    . "\", character_id: " . $characterId . "}) {\n    returning {\n      id\n      text\n    }\n  }\n}\n",
                "operationName" => "CreateQuote"
            ]
        ]);
    }

    public function deleteAll(): void
    {
        $client = new \GuzzleHttp\Client();
        $client->post('https://backend-challenge.hasura.app/v1/graphql', [
            'headers' => [
                'x-hasura-admin-secret' => 'uALQXDLUu4D9BC8jAfXgDBWm1PMpbp0pl5SQs4chhz2GG14gAVx5bfMs4I553keV',
                'content-type' => 'application/json'
            ],
            'json' => [
                'query' => "mutation DeleteAll {\n  delete_Character(where: {id: {_gt: 0}}) {\n    affected_rows\n  }\n}\n",
                "operationName" => "DeleteAll"
            ]
        ]);
    }
}
