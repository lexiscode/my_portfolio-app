<?php

namespace App\Form;

use App\Entity\Portfolio;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PortfolioFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Project Name', 'type' => 'text'],
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 3, 
                        'max' => 100, 
                        'minMessage' => 'Your name must be at least {{ limit }} characters long.',
                        'maxMessage' => 'Your name cannot be longer than {{ limit }} characters.',
                    ]),
                ],
            ])
            ->add('category', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Enter the project category', 'value' => 'Alexander Nwokorie', 'type' => 'text'],
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 3, 
                        'max' => 100, 
                        'minMessage' => 'Your name must be at least {{ limit }} characters long.',
                        'maxMessage' => 'Your name cannot be longer than {{ limit }} characters.',
                    ]),
                ],
            ])
            ->add('note', TextareaType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Type your notes...', 'type' => 'text', 'rows' => '3'],
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 3, 
                        'minMessage' => 'Your name must be at least {{ limit }} characters long.',
                    ]),
                ],
            ])
            ->add('technology', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Enter the technologies used', 'type' => 'text'],
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 3, 
                        'max' => 100, 
                        'minMessage' => 'Your name must be at least {{ limit }} characters long.',
                        'maxMessage' => 'Your name cannot be longer than {{ limit }} characters.',
                    ]),
                ],
            ])
            ->add('client', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Enter a client name if any', 'type' => 'text'],
                'constraints' => [
                    new Length([
                        'min' => 3, 
                        'max' => 100, 
                        'minMessage' => 'Your name must be at least {{ limit }} characters long.',
                        'maxMessage' => 'Your name cannot be longer than {{ limit }} characters.',
                    ]),
                ],
            ])
            ->add('first_image', FileType::class, [
                'label' => 'Upload a first image (jpeg, png)',
                'attr' => ['class' => 'form-control'],
                'mapped' => false,
            ])
            ->add('second_image', FileType::class, [
                'label' => 'Upload another image, if necessary (jpeg, png)',
                'attr' => ['class' => 'form-control'],
                'mapped' => false,
            ])
            ->add('link', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Paste any video url here', 'type' => 'text'],
                'constraints' => [
                    new Length([
                        'min' => 3, 
                        'max' => 100, 
                        'minMessage' => 'Your name must be at least {{ limit }} characters long.',
                        'maxMessage' => 'Your name cannot be longer than {{ limit }} characters.',
                    ]),
                ],
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Portfolio::class,
        ]);
    }
}
