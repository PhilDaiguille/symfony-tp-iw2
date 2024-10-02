<?php

declare(strict_types=1);

namespace App\Controller\Other;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SubscribeController extends AbstractController
{
    #[Route('/subscribe', name: 'page_subscribe')]
    public function index(): Response
    {
        return $this->render('other/abonnements.html.twig');
    }
}
