<?php

namespace App\Services;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
class Charts extends AbstractController {


    public function __construct(ChartBuilderInterface $chartBuilder)
    { $this->chartBuilder = $chartBuilder; }
    public function chartMatchs($leagueId, $teamId, $year, FootApi $footApi){
        $stats = $footApi->getTeamStats($leagueId, $teamId, $year);
        $wins = $stats['response']['fixtures']['wins']['total'];
        $draws = $stats['response']['fixtures']['draws']['total'];
        $loses = $stats['response']['fixtures']['loses']['total'];
        $chart = $this->chartBuilder->createChart(Chart::TYPE_PIE);
        $chart->setData([
           'labels'=>['Wins', 'Draws', 'Loses'],
            'datasets'=>[
                [
                'label'=>'Matchs',
                'backgroundColor' => [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)'
                ],
                'borderColor' => 'rgb(255, 99, 132)',
                'data'=>[$wins,$draws,$loses]
                ]
            ]
        ]);
        return $chart;
    }

    public function chartGoals($leagueId, $teamId, $year, FootApi $footApi)
    {
        $stats = $footApi->getTeamStats($leagueId, $teamId, $year);
        $scored = $stats['response']['goals']['for']['total']['total'];
        $concede = $stats['response']['goals']['against']['total']['total'];
        $chart = $this->chartBuilder->createChart(Chart::TYPE_BAR);
        $chart->setData([
            'labels'=>['Scored', 'Against'],
            'datasets'=>[
                [
                    'label'=>'Goals',
                    'backgroundColor' => [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)'
                    ],
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data'=>[$scored,$concede]
                ]
            ]
        ]);
        return $chart;
    }
}