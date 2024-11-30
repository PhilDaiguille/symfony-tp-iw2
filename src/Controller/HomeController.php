<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\MediaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route(path: '/', name: 'page_home')]
    public function home(
        CategoryRepository $categoryRepository,
        MediaRepository $mediaRepository,
    ): Response {
        $categories = $categoryRepository->findAll();
        $movie = $mediaRepository->findAll()[0];

        return $this->render(view: 'index.html.twig', parameters: [
            'categories' => $categories,
            'movie' => $movie,
        ]);
    }
}
