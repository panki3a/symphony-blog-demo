<?php

declare(strict_types=1);

namespace App\Blog\Post\Article\Application\Form;

use App\Blog\Post\Article\Domain\Entity\Article;
use App\Blog\Post\Author\Application\Form\AuthorFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

final class ArticleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('author', AuthorFormType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Author',
            ])
            ->add('title', TextType::class, [
                'attr' => ['class' => 'form-control', 'maxlength' => 50],
                'label' => 'Title',
                'constraints' => [
                    new NotBlank(['message' => 'Title cannot be empty']),
                    new Length([
                        'max' => 50,
                        'maxMessage' => 'Title cannot be longer than {{ limit }} characters',
                    ]),
                ],
            ])
            ->add('description', TextType::class, [
                'attr' => ['class' => 'form-control', 'maxlength' => 100],
                'label' => 'Description',
                'constraints' => [
                    new NotBlank(['message' => 'Description cannot be empty']),
                    new Length([
                        'max' => 100,
                        'maxMessage' => 'Title cannot be longer than {{ limit }} characters',
                    ]),
                ],
            ])
            ->add('content', TextareaType::class, [
                'attr' => ['class' => 'form-control', 'rows' => 5],
                'label' => 'Content',
                'constraints' => [
                    new NotBlank(['message' => 'Content cannot be empty']),
                ],
            ])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary'],
                'label' => 'Create',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
