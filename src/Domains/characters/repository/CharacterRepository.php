<?php

namespace Character\repository;

class CharacterRepository
{
    public function createCharacter($character)
    {
        $client = new \GuzzleHttp\Client();
        $response =  $client->post('https://backend-challenge.hasura.app/v1/graphql', [
            'headers' => [
                'x-hasura-admin-secret' => 'uALQXDLUu4D9BC8jAfXgDBWm1PMpbp0pl5SQs4chhz2GG14gAVx5bfMs4I553keV',
                'content-type' => 'application/json'
            ],
            'json' => [
                'query' => "mutation CreateCharacter {\n  insert_Character(objects: {name: \"" .
                    $character['name'] .
                    "\"}) {\n    returning {\n      id\n    }\n  }\n}",
                "operationName" => "CreateCharacter"
            ]
        ]);

        $data = json_decode($response->getBody(), true);
        var_dump($data);
    }

    public function deleteAll()
    {
        $client = new \GuzzleHttp\Client();
        $response =  $client->post('https://backend-challenge.hasura.app/v1/graphql', [
            'headers' => [
                'x-hasura-admin-secret' => 'uALQXDLUu4D9BC8jAfXgDBWm1PMpbp0pl5SQs4chhz2GG14gAVx5bfMs4I553keV',
                'content-type' => 'application/json'
            ],
            'json' => [
                'query' => "mutation DeleteAll {\n  delete_Character(where: {id: {_gt: 0}}) {\n    affected_rows\n  }\n}\n",
                "operationName" => "DeleteAll"
            ]
        ]);

        $data = json_decode($response->getBody(), true);
        var_dump($data);
    }
}
