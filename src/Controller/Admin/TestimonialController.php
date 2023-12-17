<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use App\Entity\Testimonial;
use App\Form\TestimonialFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[IsGranted('ROLE_USER')]
class TestimonialController extends AbstractController
{
    private $em;
    private $testimonialRepository;
    private $mailRepository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->testimonialRepository = $em->getRepository(Testimonial::class);
        $this->mailRepository = $em->getRepository(Contact::class);
    }
    
    #[Route('/admin/testimonial', name: 'app_testimonial')]
    public function index(): Response
    {
        // Retrieve courses from the database
        $testimonials = $this->testimonialRepository->findAll();

        // Retrieve mails from the database
        $mails = $this->mailRepository->findAll();

        return $this->render('backend/testimonial/index.html.twig', [
            'testimonials' => $testimonials,
            'mails' => $mails
        ]);
    }

    #[Route('/admin/testimonial/create', name: 'create_testimonial')]
    public function create(Request $request): Response
    {
        $testimonial = new Testimonial();

        $form = $this->createForm(TestimonialFormType::class, $testimonial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newTestimonial = $form->getData();
            $image = $form->get('image')->getData();

            if ($image) {
                $newFileName = uniqid() . '.' . $image->guessExtension();
                try {
                    $image->move(
                        $this->getParameter('kernel.project_dir') . '/public/uploads/testimonial',
                        $newFileName
                    );
                } catch (FileException $e) {
                    return new Response($e->getMessage());
                }
                $newTestimonial->setImage('/uploads/testimonial/' . $newFileName);
            }

            $this->em->persist($newTestimonial);
            $this->em->flush();

            // Add a flash message for creation success
            $this->addFlash('success', 'The testimonial has been created successfully!');

            return $this->redirectToRoute('app_testimonial');
        }
        
        // Retrieve mails from the database
        $mails = $this->mailRepository->findAll();

        return $this->render('backend/testimonial/create.html.twig', [
            'testimonialForm' => $form->createView(),
            'mails' => $mails
        ]);
    }


    #[Route('/admin/testimonial/edit/{id}', name: 'edit_testimonial')]
    public function edit($id, Request $request): Response
    {
        // Find the testimonial by its ID
        $testimonial = $this->testimonialRepository->find($id);

        if (!$testimonial){
            throw $this->createNotFoundException('Testimonial not found');
        }

        $form = $this->createForm(TestimonialFormType::class, $testimonial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $newTestimonial = $form->getData();
            $image = $form->get('image')->getData();

            if ($image) {
                $newFileName = uniqid() . '.' . $image->guessExtension();
                try {
                    $image->move(
                        $this->getParameter('kernel.project_dir') . '/public/uploads/testimonial',
                        $newFileName
                    );
                } catch (FileException $e) {
                    return new Response($e->getMessage());
                }
                $newTestimonial->setImage('/uploads/testimonial/' . $newFileName);
            }

            $this->em->persist($newTestimonial);
            $this->em->flush();

            // Add a flash message for creation success
            $this->addFlash('success', 'The testimonial has been updated successfully!');

            return $this->redirectToRoute('app_testimonial');
        }

        // Retrieve mails from the database
        $mails = $this->mailRepository->findAll();
        
        return $this->render('backend/testimonial/edit.html.twig', [
            'testimonialForm' => $form->createView(),
            'mails' => $mails,
            'testimonial' => $testimonial
        ]);
    }


    #[Route('/admin/testimonial/delete/{id}', methods:['GET', 'DELETE'], name: 'delete_testimonial')]
    public function delete($id): Response
    {
        
        $testimonial = $this->testimonialRepository->find($id);

        $this->em->remove($testimonial);
        $this->em->flush();

        // Add a flash message for deletion success
        $this->addFlash('success', 'The testimonial has been deleted successfully!');

        return $this->redirectToRoute('app_testimonial');
    }
}

