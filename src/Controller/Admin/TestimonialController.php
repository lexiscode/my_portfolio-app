<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class TestimonialController extends AbstractController
{
    #[Route('/admin/testimonial', name: 'app_testimonial')]
    public function index(): Response
    {
        return $this->render('backend/testimonial/index.html.twig', [
            'controller_name' => 'AboutController',
        ]);
    }

    #[Route('/admin/testimonial/create', name: 'app_create_testimonial')]
    public function create(): Response
    {
        return $this->render('backend/testimonial/create.html.twig', [
            'controller_name' => 'AboutController',
        ]);
    }
}
