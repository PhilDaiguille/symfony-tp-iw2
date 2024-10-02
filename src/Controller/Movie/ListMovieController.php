<?php

declare(strict_types=1);

namespace App\Controller\Movie;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ListMovieController extends AbstractController
{
    #[Route('/movie', name: 'page_movie_list')]
    public function index(): Response
    {
        return $this->render('movie/lists.html.twig');
    }
}
