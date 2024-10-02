<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminFilmController extends AbstractController
{
    #[Route('/admin/movies', name: 'admin_movies')]
    public function movies(): Response
    {
        return $this->render('admin/admin_films.html.twig');
    }
}
