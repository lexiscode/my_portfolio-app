<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER')]
class MailController extends AbstractController
{
    private $em;
    private $mailRepository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->mailRepository = $em->getRepository(Contact::class);
    }

    #[Route('/admin/mail', name: 'app_mail')]
    public function index(): Response
    {
        // Retrieve mails from the database
        $mails = $this->mailRepository->findAll();

        return $this->render('backend/mail/index.html.twig', [
            'mails' => $mails
        ]);
    }

    #[Route('/admin/mail/delete/{id}', methods:['GET', 'DELETE'], name: 'delete_mail')]
    public function delete($id): Response
    {
        
        $mail = $this->mailRepository->find($id);

        $this->em->remove($mail);
        $this->em->flush();

        // Add a flash message for deletion success
        $this->addFlash('success', 'The mail has been deleted successfully!');

        return $this->redirectToRoute('app_mail');
    }
 
}
