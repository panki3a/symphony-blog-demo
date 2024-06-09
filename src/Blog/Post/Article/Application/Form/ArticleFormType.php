<?php

declare(strict_types=1);

namespace App\Blog\Post\Article\Application\Form;

use App\Blog\Post\Article\Domain\Entity\Article;
use App\Blog\Post\Author\Application\Form\AuthorFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('author', AuthorFormType::class)
            ->add('title')
            ->add('description')
            ->add('content');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
