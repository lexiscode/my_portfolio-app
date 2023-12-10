<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => ['class' => 'pointer-input', 'placeholder' => 'Your name', 'type' => 'text'],
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
            ->add('email', TextType::class, [
                'attr' => ['class' => 'pointer-input', 'placeholder' => 'Your email', 'type' => 'email'],
                'constraints' => [
                    new NotBlank(),
                    new Email(['message' => 'The email "{{ value }}" is not a valid email.']),
                ],
            ])
            ->add('subject', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'pointer-input', 'placeholder' => 'Subject', 'type' => 'text'],
            ])
            ->add('message', TextareaType::class, [
                'attr' => ['class' => 'pointer-input', 'placeholder' => 'Your message', 'type' => 'text', 'rows' => '3'],
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
            'data_class' => Contact::class,
        ]);
    }
}
