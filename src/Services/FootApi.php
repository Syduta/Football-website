<?php

namespace App\Services;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class FootApi extends AbstractController {
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
                    'x-rapidapi-key' => $this->getParameter('app.api_key')            ]
            ]);
        return $response->toArray();
    }

    public function getLeagues()
    {
        $response = $this->httpClient->request(
            'GET',
            'https://v3.football.api-sports.io/leagues?current=true',
            ['headers'=>
                [
                    'x-rapidapi-host' => 'v3.football.api-sports.io',
                    'x-rapidapi-key' => $this->getParameter('app.api_key')            ]
            ]);
        return $response->toArray();
    }

    public function getSeasons()
    {
        $response = $this->httpClient->request(
            'GET',
            'https://v3.football.api-sports.io/leagues/seasons',
            ['headers'=>
                [
                    'x-rapidapi-host' => 'v3.football.api-sports.io',
                    'x-rapidapi-key' => $this->getParameter('app.api_key')            ]
            ]);
        return $response->toArray();
    }

    public function getTeamsFromLeague($leagueId, $year)
    {
        $response = $this->httpClient->request(
            'GET',
            "https://v3.football.api-sports.io/teams?league=$leagueId&season=$year",
            ['headers'=>
                [
                    'x-rapidapi-host' => 'v3.football.api-sports.io',
                    'x-rapidapi-key' => $this->getParameter('app.api_key')            ]
            ]);
        return $response->toArray();
    }

    public function getTeamStats($leagueId, $teamId, $year)
    {
        $response = $this->httpClient->request(
            'GET',
            "https://v3.football.api-sports.io/teams/statistics?league=$leagueId&team=$teamId&season=$year",
            ['headers'=>
                [
                    'x-rapidapi-host' => 'v3.football.api-sports.io',
                    'x-rapidapi-key' => $this->getParameter('app.api_key')            ]
            ]);

        return $response->toArray();
    }

    public function getSquads($teamId){
        $response = $this->httpClient->request(
            'GET',
            "https://v3.football.api-sports.io/players/squads?team=$teamId",
            ['headers'=>
                [
                    'x-rapidapi-host' => 'v3.football.api-sports.io',
                    'x-rapidapi-key' => $this->getParameter('app.api_key')
                ]
            ]);

        return $response->toArray();
    }

    public function getRanks($year, $leagueId){
        $response = $this->httpClient->request(
            'GET',
            "https://v3.football.api-sports.io/fixtures/rounds?season=$year&league=$leagueId&current=true",
            ['headers'=>
                [
                    'x-rapidapi-host' => 'v3.football.api-sports.io',
                    'x-rapidapi-key' => $this->getParameter('app.api_key')
                ]
            ]);

        return $response->toArray();
    }
}