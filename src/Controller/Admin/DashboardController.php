<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER')]
class DashboardController extends AbstractController
{
    private $em;
    private $mailRepository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->mailRepository = $em->getRepository(Contact::class);
    }
    
    #[Route('/admin/dashboard', name: 'app_dashboard')]
    public function index(): Response
    {
        // Retrieve mails from the database
        $mails = $this->mailRepository->findAll();

        return $this->render('backend/dashboard/index.html.twig', [
            'mails' => $mails,
        ]);
    }
}
