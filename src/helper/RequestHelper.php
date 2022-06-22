<?php

namespace Helper;

class RequestHelper
{
    public function sendRepositoryRequest(string $query, string $operation = null): array
    {
        $json = ['query' => $query];
        if ($operation != null) {
            $json[] = ["operationName" => $operation];
        }
        $client = new \GuzzleHttp\Client();
        $response =  $client->post($_ENV['API_URL'], [
            'headers' => [
                'x-hasura-admin-secret' => $_ENV['API_SECRET'],
                'content-type' => 'application/json'
            ],
            'json' => $json
        ]);

        return json_decode($response->getBody(), true);
    }

    public function sendGetRequest(string $url): array
    {
        $client = new \GuzzleHttp\Client();
        $response =  $client->get($url);
        return json_decode($response->getBody(), true);
    }
}
