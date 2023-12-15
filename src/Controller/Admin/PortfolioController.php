<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use App\Entity\Portfolio;
use App\Form\PortfolioFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[IsGranted('ROLE_USER')]
class PortfolioController extends AbstractController
{
    private $em;
    private $portfolioRepository;
    private $mailRepository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->portfolioRepository = $em->getRepository(Portfolio::class);
        $this->mailRepository = $em->getRepository(Contact::class);
    }
    
    #[Route('/admin/portfolio', name: 'app_admin_portfolio')]
    public function index(): Response
    {
        // Retrieve blogs from the database
        $portfolios = $this->portfolioRepository->findAll();

        // Retrieve mails from the database
        $mails = $this->mailRepository->findAll();

        return $this->render('backend/portfolio/index.html.twig', [
            'portfolios' => $portfolios,
            'mails' => $mails
        ]);
    }

    #[Route('/admin/portfolio/create', name: 'create_portfolio')]
    public function create(Request $request): Response
    {
        $portfolio = new Portfolio;

        $form = $this->createForm(PortfolioFormType::class, $portfolio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newPortfolio = $form->getData();

            // Get the selected category value from the form
            $selectedCategory = $form->get('category')->getData();

            // Perform the checks and set categories accordingly
            if ($selectedCategory === 'Vanilla PHP') {
                $newPortfolio->setCategory('Vanilla PHP');
            } elseif ($selectedCategory === 'Laravel') {
                $newPortfolio->setCategory('Laravel');
            } elseif ($selectedCategory === 'Symfony') {
                $newPortfolio->setCategory('Symfony');
            }elseif ($selectedCategory === 'APIs') {
                $newPortfolio->setCategory('APIs');
            }

            // Upload first image
            $this->uploadImage($form, 'first_image', $newPortfolio);

            // Upload second image
            $this->uploadImage($form, 'second_image', $newPortfolio);

            $this->em->persist($newPortfolio);
            $this->em->flush();

            // Add a flash message for creation success
            $this->addFlash('success', 'The portfolio has been created successfully!');

            return $this->redirectToRoute('app_admin_portfolio');
        }

        // Retrieve mails from the database
        $mails = $this->mailRepository->findAll();
        
        return $this->render('backend/portfolio/create.html.twig', [
            'portfolioForm' => $form->createView(),
            'mails' => $mails
        ]);
    }

    private function uploadImage(FormInterface $form, string $fieldName, Portfolio $portfolio): void
    {
        $image = $form->get($fieldName)->getData();

        if ($image) {
            $newFileName = uniqid() . '.' . $image->guessExtension();
            try {
                $image->move(
                    $this->getParameter('kernel.project_dir') . '/public/uploads/portfolio',
                    $newFileName
                );
            } catch (FileException $e) {
                throw new \Exception($e->getMessage());
            }
            // Dynamically construct the setter method name
            $setterMethod = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $fieldName)));
            $portfolio->$setterMethod('/uploads/portfolio/' . $newFileName);
        }
    }

    #[Route('/admin/portfolio/edit/{id}', name: 'edit_portfolio')]
    public function edit($id, Request $request): Response
    {
        // Find the portfolio by its ID
        $portfolio = $this->portfolioRepository->find($id);

        if (!$portfolio){
            throw $this->createNotFoundException('Portfolio not found');
        }

        $form = $this->createForm(PortfolioFormType::class, $portfolio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newPortfolio = $form->getData();
            
            // Get the selected category value from the form
            $selectedCategory = $form->get('category')->getData();

            // Perform the checks and set categories accordingly
            if ($selectedCategory === 'Vanilla PHP') {
                $newPortfolio->setCategory('Vanilla PHP');
            } elseif ($selectedCategory === 'Laravel') {
                $newPortfolio->setCategory('Laravel');
            } elseif ($selectedCategory === 'Symfony') {
                $newPortfolio->setCategory('Symfony');
            }elseif ($selectedCategory === 'APIs') {
                $newPortfolio->setCategory('APIs');
            }

            // Upload first image
            $this->uploadImage($form, 'first_image', $newPortfolio);

            // Upload second image
            $this->uploadImage($form, 'second_image', $newPortfolio);

            $this->em->persist($newPortfolio);
            $this->em->flush();

            // Add a flash message for creation success
            $this->addFlash('success', 'The portfolio has been updated successfully!');

            return $this->redirectToRoute('app_admin_portfolio');
        }

        // Retrieve mails from the database
        $mails = $this->mailRepository->findAll();
        
        return $this->render('backend/portfolio/edit.html.twig', [
            'portfolioForm' => $form->createView(),
            'mails' => $mails
        ]);
    }

    #[Route('/admin/portfolio/delete/{id}', methods:['GET', 'DELETE'], name: 'delete_portfolio')]
    public function delete($id): Response
    {
        $portfolio = $this->portfolioRepository->find($id);

        $this->em->remove($portfolio);
        $this->em->flush();

        // Add a flash message for deletion success
        $this->addFlash('success', 'The portfolio has been deleted successfully!');

        return $this->redirectToRoute('app_admin_portfolio');
    }
}

