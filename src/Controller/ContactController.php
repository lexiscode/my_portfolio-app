<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/contact', name: 'app_contact')]
    public function createContact(Request $request): Response
    {
        // Create a new contact message
        $contact = new Contact();
        
        // Create the form and handle the request
        $form = $this->createForm(ContactFormType::class, $contact);
        $form->handleRequest($request);

        // If the form is submitted and valid, associate the course with the user and persist it
        if ($form->isSubmitted() && $form->isValid()) {

            // Persist the course and user to the database
            $this->em->persist($contact);
            $this->em->flush();

            // Add a flash message and redirect to the main course page
            $this->addFlash('success', 'Your message has been sent successfully!');
            return $this->redirectToRoute('app_contact');
        } 

        return $this->render('frontend/contact/index.html.twig', [
            'contactForm' => $form->createView()
        ]);
    }   
}

