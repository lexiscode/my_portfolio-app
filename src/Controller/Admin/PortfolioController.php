<?php

namespace App\Controller\Admin;

use App\Entity\Portfolio;
use App\Form\PortfolioFormType;
use Doctrine\ORM\EntityManagerInterface;
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

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->portfolioRepository = $em->getRepository(Portfolio::class);
    }
    
    #[Route('/admin/portfolio', name: 'app_portfolio')]
    public function index(): Response
    {
        // Retrieve blogs from the database
        $portfolios = $this->portfolioRepository->findAll();

        return $this->render('backend/portfolio/index.html.twig', [
            'portfolios' => $portfolios
        ]);
    }

    #[Route('/admin/portfolio/create', name: 'create_portfolio')]
    public function create(Request $request, Portfolio $portfolio): Response
    {
        
        $form = $this->createForm(PortfolioFormType::class, $portfolio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newPortfolio = $form->getData();
            $image = $form->get('image')->getData();

            if ($image) {
                $newFileName = uniqid() . '.' . $image->guessExtension();
                try {
                    $image->move(
                        $this->getParameter('kernel.project_dir') . '/public/uploads/portfolio',
                        $newFileName
                    );
                } catch (FileException $e) {
                    return new Response($e->getMessage());
                }
                $newPortfolio->setImage('/uploads/portfolio/' . $newFileName);
            }

            $this->em->persist($newPortfolio);
            $this->em->flush();

            // Add a flash message for creation success
            $this->addFlash('success', 'The portfolio has been created successfully!');

            return $this->redirectToRoute('app_portfolio');
        }
        
        return $this->render('backend/portfolio/create.html.twig', [
            'portfolioForm' => $form->createView()
        ]);
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
            $image = $form->get('image')->getData();

            if ($image) {
                $newFileName = uniqid() . '.' . $image->guessExtension();
                try {
                    $image->move(
                        $this->getParameter('kernel.project_dir') . '/public/uploads/portfolio',
                        $newFileName
                    );
                } catch (FileException $e) {
                    return new Response($e->getMessage());
                }
                $newPortfolio->setImage('/uploads/portfolio/' . $newFileName);
            }

            $this->em->persist($newPortfolio);
            $this->em->flush();

            // Add a flash message for creation success
            $this->addFlash('success', 'The portfolio has been updated successfully!');

            return $this->redirectToRoute('app_portfolio');
        }
        
        return $this->render('backend/portfolio/edit.html.twig', [
            'portfolioForm' => $form->createView()
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

        return $this->redirectToRoute('app_portfolio');
    }
}

