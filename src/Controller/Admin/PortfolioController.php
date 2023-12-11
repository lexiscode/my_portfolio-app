<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class PortfolioController extends AbstractController
{
    #[Route('/admin/portfolio', name: 'app_portfolio')]
    public function index(): Response
    {
        return $this->render('backend/portfolio/index.html.twig', [
            'controller_name' => 'AboutController',
        ]);
    }
}
