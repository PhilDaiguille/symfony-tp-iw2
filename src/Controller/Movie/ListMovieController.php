<?php

declare(strict_types=1);

namespace App\Controller\Movie;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ListMovieController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/movie', name: 'page_movie_list')]
    public function index(): Response
    {
        $playlists = $this->getUser()->getPlaylists();

        return $this->render('movie/lists.html.twig', [
            'playlists' => $playlists,
        ]);
    }
}
