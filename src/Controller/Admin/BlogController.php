<?php

namespace App\Controller\Admin;

use App\Entity\Blog;
use App\Form\BlogFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[IsGranted('ROLE_USER')]
class BlogController extends AbstractController
{
    private $em;
    private $blogRepository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->blogRepository = $em->getRepository(Blog::class);
    }
    
    #[Route('/admin/blog', name: 'app_admin_blog')]
    public function index(): Response
    {
        // Retrieve blogs from the database
        $blogs = $this->blogRepository->findAll();

        return $this->render('backend/blog/index.html.twig', [
            'blogs' => $blogs
        ]);
    }

    #[Route('/admin/blog/create', name: 'create_blog')]
    public function create(Request $request): Response
    {
        $blog = new Blog();

        $form = $this->createForm(BlogFormType::class, $blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newBlog = $form->getData();
            $image = $form->get('image')->getData();

            if ($image) {
                $newFileName = uniqid() . '.' . $image->guessExtension();
                try {
                    $image->move(
                        $this->getParameter('kernel.project_dir') . '/public/uploads/blog',
                        $newFileName
                    );
                } catch (FileException $e) {
                    return new Response($e->getMessage());
                }
                $newBlog->setImage('/uploads/blog/' . $newFileName);
            }

            $this->em->persist($newBlog);
            $this->em->flush();

            // Add a flash message for creation success
            $this->addFlash('success', 'The blog has been created successfully!');

            return $this->redirectToRoute('app_admin_blog');
        }
        
        return $this->render('backend/blog/create.html.twig', [
            'blogForm' => $form->createView()
        ]);
    }

    #[Route('/admin/blog/edit/{id}', name: 'edit_blog')]
    public function edit($id, Request $request): Response
    {
        // Find the blog by its ID
        $blog = $this->blogRepository->find($id);

        if (!$blog){
            throw $this->createNotFoundException('Blog not found');
        }

        $form = $this->createForm(BlogFormType::class, $blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $newBlog = $form->getData();
            $image = $form->get('image')->getData();

            if ($image) {
                $newFileName = uniqid() . '.' . $image->guessExtension();
                try {
                    $image->move(
                        $this->getParameter('kernel.project_dir') . '/public/uploads/blog',
                        $newFileName
                    );
                } catch (FileException $e) {
                    return new Response($e->getMessage());
                }
                $newBlog->setImage('/uploads/blog/' . $newFileName);
            }

            $this->em->persist($newBlog);
            $this->em->flush();

            // Add a flash message for creation success
            $this->addFlash('success', 'The blog has been updated successfully!');

            return $this->redirectToRoute('app_admin_blog');
        }
        
        return $this->render('backend/blog/edit.html.twig', [
            'blogForm' => $form->createView()
        ]);
    }

    #[Route('/admin/blog/delete/{id}', methods:['GET', 'DELETE'], name: 'delete_blog')]
    public function delete($id): Response
    {
        
        $blog = $this->blogRepository->find($id);

        $this->em->remove($blog);
        $this->em->flush();

        // Add a flash message for deletion success
        $this->addFlash('success', 'The blog has been deleted successfully!');

        return $this->redirectToRoute('app_admin_blog');
    }
}
