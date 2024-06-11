<?php

declare(strict_types=1);

namespace App\Blog\Post\Comment\Application\Form;

use App\Blog\Post\Comment\Domain\Entity\Comment;
use App\Blog\Post\Comment\User\Application\Form\UserFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

final class CommentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('user', UserFormType::class)
            ->add('content', TextType::class, [
                'required' => true,
                'label' => 'Comment',
                'constraints' => [
                    new NotBlank(['message' => 'Comment cannot be empty']),
                ],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Post Comment',
                'attr' => ['class' => 'btn btn-primary'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
