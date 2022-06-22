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
        $response =  $client->post('https://backend-challenge.hasura.app/v1/graphql', [
            'headers' => [
                'x-hasura-admin-secret' => 'uALQXDLUu4D9BC8jAfXgDBWm1PMpbp0pl5SQs4chhz2GG14gAVx5bfMs4I553keV',
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
