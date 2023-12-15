<?php

namespace App\Form;

use App\Entity\Portfolio;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('category', ChoiceType::class, [
                'label' => 'Enter the project category',
                'attr' => ['class' => 'form-control', 'type' => 'text'],
                'multiple' => false, // Allow single choice, rather than multiple
                'choices' => [
                    'Vanilla PHP' => 'Vanilla PHP', 
                    'Laravel' => 'Laravel',   
                    'Symfony' => 'Symfony', 
                    'APIs' => 'APIs',
                ],
                'constraints' => [new NotBlank()],
            ])
            ->add('note', CKEditorType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Type your notes...', 'type' => 'text', 'rows' => '3'],
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 3, 
                        'minMessage' => 'Your name must be at least {{ limit }} characters long.',
                    ]),
                ],
            ])
            ->add('cat', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Enter either cat1 cat2 cat3 or cat4 with a space', 'type' => 'text'],
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 4, 
                        'max' => 20, 
                        'minMessage' => 'Your name must be at least {{ limit }} characters long.',
                        'maxMessage' => 'Your name cannot be longer than {{ limit }} characters.',
                    ]),
                ],
            ])
            ->add('client', TextType::class, [
                'required' => false,
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
            ->add('image', FileType::class, [
                'required' => false,
                'label' => 'Upload an image (jpeg, png)',
                'attr' => ['class' => 'form-control'],
                'mapped' => false,
            ])
            ->add('link', TextType::class, [
                'required' => false,
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
            ->add('site_url', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control', 'placeholder' => 'Enter the project url', 'type' => 'text'],
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
