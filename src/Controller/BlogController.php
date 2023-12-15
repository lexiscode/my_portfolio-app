<?php

namespace App\Controller;

use App\Entity\Blog;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{

    private $blogRepository;
    
    public function __construct(EntityManagerInterface $em)
    {
        $this->blogRepository = $em->getRepository(Blog::class);
    }

    #[Route('/blog', name: 'app_blog')]
    public function index(): Response
    {
        // Retrieve blogs from the database
        $blogs = $this->blogRepository->findAll();

        return $this->render('frontend/blog/index.html.twig', [
            'blogs' => $blogs,
        ]);
    }

    #[Route('/blog-detail/{id}', name: 'app_blog_detail')]
    public function blogDetail($id, Request $request): Response
    {
        // Find the blog by its ID
        $blog = $this->blogRepository->find($id);

        // Retrieve blogs from the database
        $blogs = $this->blogRepository->findAll();

        if (!$blog){
            throw $this->createNotFoundException('Blog not found');
        }

        return $this->render('frontend/blog-details/index.html.twig', [
            'blog' => $blog,
            'blogs' => $blogs
        ]);
    }
}

