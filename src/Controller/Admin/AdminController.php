<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class AdminController extends AbstractController
{
    #[Route('/admin')]
    public function index(): Response
    {
        return $this->render('admin/admin.html.twig');
    }

    #[Route('/admin/films', name: 'admin_films')]
    public function films(): Response
    {
        return $this->render('admin/admin_films.html.twig');
    }

    #[Route('/admin/add-films', name: 'admin_add_films')]
    public function addFilms(): Response
    {
        return $this->render('admin/add_films.html.twig');
    }

    #[Route('/admin/users', name: 'admin_users')]
    public function users(): Response
    {
        return $this->render('admin/admin_users.html.twig');
    }
}
