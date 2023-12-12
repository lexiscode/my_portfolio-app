<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Contact;
use App\Form\ProfileFormType;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[IsGranted('ROLE_USER')]
class ProfileController extends AbstractController
{
    private $em;
    private $profileRepository;
    private $passwordEncoder;
    private $mailRepository;

    public function __construct(EntityManagerInterface $em, UserPasswordHasherInterface $passwordEncoder)
    {
        $this->em = $em;
        $this->profileRepository = $em->getRepository(User::class);
        $this->mailRepository = $em->getRepository(Contact::class);
        $this->passwordEncoder = $passwordEncoder;
    }

    #[Route('/admin/profile/{id}', name: 'app_profile')]
    public function update($id, Request $request): Response
    {
        // Find the profile by its ID
        $profile = $this->profileRepository->find($id);

        if (!$profile) {
            throw $this->createNotFoundException('Profile not found');
        }

        $form = $this->createForm(ProfileFormType::class, $profile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Update the password only if a new password is provided
            if ($newPassword = $form->get('password')->getData()) {
                $encodedPassword = $this->passwordEncoder->hashPassword($profile, $newPassword);
                $profile->setPassword($encodedPassword);
            }

            $this->em->persist($profile);
            $this->em->flush();

            // Add a flash message for update success
            $this->addFlash('success', 'The profile has been updated successfully!');

            return $this->redirectToRoute('app_profile', ['id' => 1]);

        }

        // Retrieve mails from the database
        $mails = $this->mailRepository->findAll();

        return $this->render('backend/profile/index.html.twig', [
            'profileForm' => $form->createView(),
            'mails' => $mails
        ]);
    }
}