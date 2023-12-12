<?php

namespace App\Form;

use App\Entity\Blog;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BlogFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Title', 'type' => 'text'],
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
            ->add('author', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Enter an author name', 'value' => 'Alexander Nwokorie', 'type' => 'text'],
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
            ->add('brand', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Enter a brand name', 'type' => 'text'],
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
                'label' => 'Upload a cover image (jpeg, png)',
                'attr' => ['class' => 'form-control'],
                'mapped' => false,
            ])
            ->add('content', CKEditorType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Type your contents...', 'type' => 'text', 'rows' => '3'],
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 3, 
                        'minMessage' => 'Your name must be at least {{ limit }} characters long.',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Blog::class,
        ]);
    }
}
