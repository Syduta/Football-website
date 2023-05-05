<?php

namespace App\Services;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class Charts extends AbstractController {


    public function __construct(ChartBuilderInterface $chartBuilder)
    { $this->chartBuilder = $chartBuilder; }
    public function chartMatchs(){
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
                'data'=>[20,10,8]
                ]
            ]
        ]);
        return $chart;
    }
}