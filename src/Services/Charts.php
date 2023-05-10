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
                        'rgb(228, 24, 24)',
                        'rgb(54, 162, 235)'
                    ],
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data'=>[$scored,$concede]
                ]
            ]
        ]);
        return $chart;
    }

    public function chartBooked($leagueId, $teamId, $year, FootApi $footApi){
        $stats = $footApi->getTeamStats($leagueId, $teamId, $year);
        $labels = ['0-15','16-30','31-45','46-60','61-75','76-90','91+'];
        $chart = $this->chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels'=>$labels,
            'datasets'=>[
                [
                    'label'=>'Total number of yellow cards',
                    'backgroundColor' => [
                        'yellow'
                    ],
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data'=>[
                        $stats['response']['cards']['yellow']['0-15']['total'],
                        $stats['response']['cards']['yellow']['16-30']['total'],
                        $stats['response']['cards']['yellow']['31-45']['total'],
                        $stats['response']['cards']['yellow']['46-60']['total'],
                        $stats['response']['cards']['yellow']['61-75']['total'],
                        $stats['response']['cards']['yellow']['76-90']['total'],
                        $stats['response']['cards']['yellow']['91-105']['total']
                    ],
                    'fill'=>false,
                    'tension'=>0.1
                ],
                [
                    'label' => 'Total number of red cards',
                    'backgroundColor' => [
                        'red'
                    ],
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => [
                        $stats['response']['cards']['red']['0-15']['total'],
                        $stats['response']['cards']['red']['16-30']['total'],
                        $stats['response']['cards']['red']['31-45']['total'],
                        $stats['response']['cards']['red']['46-60']['total'],
                        $stats['response']['cards']['red']['61-75']['total'],
                        $stats['response']['cards']['red']['76-90']['total'],
                        $stats['response']['cards']['red']['91-105']['total']
                    ],
                    'fill' => false,
                    'tension' => 0.1
                ]
            ]
        ]);
        return $chart;
    }
}