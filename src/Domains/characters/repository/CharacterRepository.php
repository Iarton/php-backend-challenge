<?php

namespace Character\repository;

use GuzzleHttp\Client;


class CharacterRepository
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
            $characterArray[] = $character;
        }

        return 'fim';
    }
}
