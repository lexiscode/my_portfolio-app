<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class BlogController extends AbstractController
{
    #[Route('/admin/blog', name: 'app_blog')]
    public function index(): Response
    {
        return $this->render('backend/blog/index.html.twig', [
            'controller_name' => 'AboutController',
        ]);
    }
}
