<?php

declare(strict_types=1);

namespace App\Controller\Movie;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MovieController extends AbstractController
{
    #[Route('/movie', name: 'movie_list')]
    public function index(): Response
    {
        return $this->render('movie/lists.html.twig');
    }

    #[Route('/movie/detail', name: 'movie_detail')]
    public function detail(): Response
    {
        return $this->render('movie/detail.html.twig');
    }

    #[Route('/movie/detail-serie', name: 'movie_detail_serie')]
    public function detail_serie(): Response
    {
        return $this->render('movie/detail_serie.html.twig');
    }

}
