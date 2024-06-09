<?php

declare(strict_types=1);

namespace App\Blog\Post\Article\Application\Command;

use App\Blog\Post\Article\Domain\Entity\Article;
use App\Blog\Post\Article\Domain\Repository\ArticleRepositoryInterface;
use App\Blog\Post\Author\Application\Command\CreateAuthorCommand;
use App\Blog\Post\Author\Domain\Entity\Author;
use App\Blog\Post\Author\Domain\Repository\AuthorRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\String\Slugger\AsciiSlugger;

#[AsMessageHandler]
final class CreateArticleCommandHandler
{
    use HandleTrait;

    public function __construct(
        private readonly ArticleRepositoryInterface $articleRepository,
        private readonly AuthorRepositoryInterface $authorRepository,
        private MessageBusInterface $messageBus,
    ) {
    }

    public function __invoke(CreateArticleCommand $command): Article
    {
        $author = $this->getAuthor($command);
        $article = (new Article())
            ->setTitle($command->title)
            ->setSlug((new AsciiSlugger())->slug($command->title)->toString())
            ->setDescription($command->description)
            ->setContent($command->content)
            ->setAuthor($author);

        $this->articleRepository->save($article);

        return $article;
    }

    private function getAuthor(CreateArticleCommand $command): Author
    {
        $author = $this->authorRepository->findByEmail($command->authorEmail);
        if (!$author) {
            $createAuthorCommnad = new CreateAuthorCommand(
                email: $command->authorEmail,
                name: $command->authorName,
                surname: $command->authorSurname
            );
            $author = $this->handle($createAuthorCommnad);
        }

        return $author;
    }
}
