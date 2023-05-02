<?php

namespace App\Controller;

use App\Services\FootApi;
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
}