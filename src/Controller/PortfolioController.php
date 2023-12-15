<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Entity\Portfolio;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PortfolioController extends AbstractController
{
    private $portfolioRepository;
    private $blogRepository;
    
    public function __construct(EntityManagerInterface $em)
    {
        $this->portfolioRepository = $em->getRepository(Portfolio::class);
        $this->blogRepository = $em->getRepository(Blog::class);
    }

    #[Route('/portfolio', name: 'app_portfolio')]
    public function index(): Response
    {
        // Retrieve blogs from the database
        $portfolios = $this->portfolioRepository->findAll();

        return $this->render('frontend/portfolio/index.html.twig', [
            'portfolios' => $portfolios,
        ]);
    }

    #[Route('/portfolio-detail/{id}', name: 'app_portfolio_detail')]
    public function portfolioDetail($id, Request $request): Response
    {
        // Find the portfolio by its ID
        $portfolio = $this->portfolioRepository->find($id);

        // Retrieve blogs from the database
        $blogs = $this->blogRepository->findAll();

        return $this->render('frontend/portfolio-details/index.html.twig', [
            'portfolio' => $portfolio,
            'blogs' => $blogs
        ]);
    }
}

