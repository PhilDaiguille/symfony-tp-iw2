<?php

declare(strict_types=1);

namespace App\Controller\Movie;

use App\Repository\MovieRepository;
use App\Repository\SerieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MovieController extends AbstractController
{
    #[Route('/media/{id}', name: 'page_movie_detail')]
    public function detail(
        string $id,
        MovieRepository $movieRepository,
        SerieRepository $serieRepository,
    ): Response {
        $repository = [];
        if ($movieRepository->find($id)) {
            $repository = $movieRepository->find($id);
        } else {
            $repository = $serieRepository->find($id);
        }

        return $this->render('movie/detail.html.twig', [
            'movie' => $repository,
        ]);
    }

    #[Route('/movie/serie', name: 'page_movie_detail_serie')]
    public function detail_serie(): Response
    {
        return $this->render('movie/detail_serie.html.twig');
    }
}
