<?php

namespace App\Controller;

use App\Services\FootApi;
use App\Services\Charts;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;

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
        dump($leagues);
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
        $teams = $footApi->getTeams($leagueId, $year);
        dump($teams);
        return $this->render('front/teams.html.twig',[
            'teams'=>$teams
        ]);
    }

    #[Route('/team-stats/{leagueId}/{teamId}/{year}',name: 'team-stats')]
    public function showTeamStats($leagueId, $teamId, $year, FootApi $footApi, Charts $charts)
    {
        $stats = $footApi->getTeamStats($leagueId, $teamId,  $year);
        $chart = $charts->chartMatchs();
        dump($stats);
        dump($chart);
        return $this->render('front/team-stats.html.twig',[
            'stats'=>$stats,
            'chart'=>$chart
        ]);
    }
}