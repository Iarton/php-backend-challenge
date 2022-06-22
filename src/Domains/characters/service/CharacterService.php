<?php

namespace Character\service;

use Character\repository\CharacterRepository;

class CharacterService
{
    public function create()
    {
        $characterArray = [];
        $client = new \GuzzleHttp\Client();
        $response =  $client->get('https://thronesapi.com/api/v2/Characters');
        $data = json_decode($response->getBody(), true);
        foreach ($data as $item) {
            $character['name'] = $item['fullName'];
            $character['image_url'] = $item['imageUrl'];
            $slug = $item['firstName'] != "" ? strtolower($item['firstName']) : strtolower($item['lastName']);
            $quotesResponse =  $client->get('https://api.gameofthronesquotes.xyz/v1/character/' . $slug);
            $quotes = json_decode($quotesResponse->getBody(), true);
            if ($quotes != null) {
                $character['quotes'] = $quotes[0]['quotes'];
            }

            $characterRepository = new CharacterRepository();
            $characterRepository->createCharacter($character);
            $characterArray[] = $character;
        }

        return 'fim';
    }

    public function getAll()
    {
        $client = new \GuzzleHttp\Client();
        $response =  $client->post('https://backend-challenge.hasura.app/v1/graphql', [
            'headers' => [
                'x-hasura-admin-secret' => 'uALQXDLUu4D9BC8jAfXgDBWm1PMpbp0pl5SQs4chhz2GG14gAVx5bfMs4I553keV',
                'content-type' => 'application/json'
            ],
            'json' => ['query' => "{\n  Character {\n    Quotes {\n      text\n      id\n    }\n    id\n    image_url\n    name\n  }\n}\n"]
        ]);
        $data = json_decode($response->getBody(), true);
        var_dump($data);

        return 'fim';
    }

    public function deleteAll()
    {
        $characterRepository = new CharacterRepository();
        $characterRepository->deleteAll();

        return 'deleted';
    }
}
