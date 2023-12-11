<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class MailController extends AbstractController
{
    #[Route('/admin/mail', name: 'app_mail')]
    public function index(): Response
    {
        return $this->render('backend/mail/index.html.twig', [
            'controller_name' => 'AboutController',
        ]);
    }
}
