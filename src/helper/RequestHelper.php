<?php

namespace Helper;

class RequestHelper
{
    private $client;

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client();
    }

    public function sendRepositoryRequest(string $query, string $operation = null): array
    {
        $json = ['query' => $query];
        if ($operation != null) {
            $json[] = ["operationName" => $operation];
        }
        $response =  $this->client->post($_ENV['API_URL'], [
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
        $response = $this->client->get($url);
        return json_decode($response->getBody(), true);
    }
}
