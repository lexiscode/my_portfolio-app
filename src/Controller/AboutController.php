<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Testimonial;
use Doctrine\ORM\EntityManagerInterface;

class AboutController extends AbstractController
{
   
    private $testimonialRepository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->testimonialRepository = $em->getRepository(Testimonial::class);
    }

    #[Route('/about', name: 'app_about')]
    public function index(): Response
    {
        // Retrieve courses from the database
        $testimonials = $this->testimonialRepository->findAll();

        return $this->render('frontend/about/index.html.twig', [
            'testimonials' => $testimonials,
        ]);
    }
}

