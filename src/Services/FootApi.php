<?php

namespace App\Services;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class FootApi{
    private $httpClient;
    //je crée un constructeur pour pouvoir faire appel à l'api
    public function __construct(HttpClientInterface $httpClient)
    { $this->httpClient = $httpClient; }

    public function getCountries()
    {
        $response = $this->httpClient->request(
            'GET',
            'https://v3.football.api-sports.io/countries',
            ['headers'=>
                [
                    'x-rapidapi-host' => 'v3.football.api-sports.io',
                    'x-rapidapi-key' => $API_KEY                ]
            ]);
        return $response->toArray();
    }
}