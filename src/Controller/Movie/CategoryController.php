<?php

declare(strict_types=1);

namespace App\Controller\Movie;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    #[Route('/category', name: 'movie_category')]
    public function category(): Response
    {
        return $this->render('movie/category.html.twig');
    }
    #[Route('/discover', name: 'movie_discover')]
    public function discover(): Response
    {
        return $this->render('movie/discover.html.twig');
    }
}
