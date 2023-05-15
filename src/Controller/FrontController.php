<?php

namespace App\Controller;

use App\Services\FootApi;
use App\Services\Charts;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function showHome()
    {
        return $this->render('base.html.twig');
    }

    #[Route('/countries', name: 'countries')]
    public function showCountries(FootApi $footApi)
    {
        $countries= $footApi->getCountries();
        dump($countries);
        return $this->render('front/countries.html.twig',[
            'countries'=>$countries
        ]);
    }

    #[Route('/leagues', name: 'leagues')]
    public function showLeagues(FootApi $footApi)
    {
        $leagues= $footApi->getLeagues();
        dump($leagues['response']);
        return $this->render('front/leagues.html.twig',[
            'leagues'=>$leagues
        ]);
    }

    #[Route('/seasons', name: 'seasons')]
    public function showSeasons(FootApi $footApi)
    {
        $seasons= $footApi->getSeasons();
        dump($seasons);
        return $this->render('front/seasons.html.twig',[
            'seasons'=>$seasons
        ]);
    }

    #[Route('/teams/{leagueId}/{year}', name: 'teams')]
    public function showTeams($leagueId, $year, FootApi $footApi)
    {
        $teams = $footApi->getTeamsFromLeague($leagueId, $year);
        dump($teams);
        return $this->render('front/teams.html.twig',[
            'teams'=>$teams
        ]);
    }

    #[Route('/team-stats/{leagueId}/{teamId}/{year}',name: 'team-stats')]
    public function showTeamStats($leagueId, $teamId, $year, FootApi $footApi, Charts $charts)
    {
        $stats = $footApi->getTeamStats($leagueId, $teamId, $year);
        $chartMatchs = $charts->chartMatchs($leagueId, $teamId, $year, $footApi);
        $chartGoals = $charts->chartGoals($leagueId, $teamId, $year, $footApi);
        $chartBooked = $charts->chartBooked($leagueId, $teamId, $year, $footApi);
        dump($stats['response']);
        return $this->render('front/team-stats.html.twig',[
            'stats'=>$stats,
            'chartMatchs'=>$chartMatchs,
            'chartGoals'=>$chartGoals,
            'chartBooked'=>$chartBooked,
        ]);
    }

    #[Route('/team-squad/{teamId}', name: 'team-squad')]
    public function showSquad($teamId , FootApi $footApi){
        $squad = $footApi->getSquads($teamId);
        dump($squad);
        return $this->render('front/team-squad.html.twig',
        ['squad'=>$squad]);
    }

    #[Route('/ranking/{year}/{leagueId}', name: 'ranking')]
    public function showRanking($year, $leagueId, FootApi $footApi){
        $rank = $footApi->getRanks($year, $leagueId);
        dump($rank);
        return $this->render('front/ranking.html.twig',['rank'=>$rank]);
    }
}