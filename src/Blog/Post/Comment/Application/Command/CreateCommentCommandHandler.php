<?php

declare(strict_types=1);

namespace App\Blog\Post\Comment\Application\Command;

use App\Blog\Post\Article\Domain\Entity\Article;
use App\Blog\Post\Article\Domain\Repository\ArticleRepositoryInterface;
use App\Blog\Post\Comment\Domain\Entity\Comment;
use App\Blog\Post\Comment\Domain\Repository\CommentRepositoryInterface;
use App\Blog\Post\Comment\User\Application\Command\CreateUserCommand;
use App\Blog\Post\Comment\User\Domain\Entity\User;
use App\Blog\Post\Comment\User\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
final class CreateCommentCommandHandler
{
    use HandleTrait;

    public function __construct(
        private readonly CommentRepositoryInterface $commentRepository,
        private readonly ArticleRepositoryInterface $articleRepository,
        private readonly UserRepositoryInterface $userRepository,
        private MessageBusInterface $messageBus,
    ) {
    }

    public function __invoke(CreateCommentCommand $command): Comment
    {
        $article = $this->getArticle($command);
        $user = $this->getUser($command);

        $comment = (new Comment())
            ->setContent($command->content)
            ->setArticle($article)
            ->setAccepted(true) // By default, comments are accepted/visible
            ->setUser($user);

        $this->commentRepository->save($comment);

        return $comment;
    }

    private function getArticle(CreateCommentCommand $command): Article
    {
        $article = $this->articleRepository->find($command->articleId);
        if (!$article) {
            throw new \InvalidArgumentException('Article not found');
        }

        return $article;
    }

    private function getUser(CreateCommentCommand $command): User
    {
        $user = $this->userRepository->findByEmail($command->userEmail);
        if (!$user) {
            $createUserCommand = new CreateUserCommand(
                email: $command->userEmail,
                name: $command->userName,
                surname: $command->userSurname
            );
            $user = $this->handle($createUserCommand);
        }

        return $user;
    }
}
