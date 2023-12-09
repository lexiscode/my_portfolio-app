<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'app_blog')]
    public function index(): Response
    {
        return $this->render('frontend/blog/index.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    #[Route('/blog-detail', name: 'app_blog_detail')]
    public function blogDetail(): Response
    {
        return $this->render('frontend/blog-details/index.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }
}
