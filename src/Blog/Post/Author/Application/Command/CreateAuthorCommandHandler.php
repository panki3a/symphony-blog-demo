<?php

declare(strict_types=1);

namespace App\Blog\Post\Author\Application\Command;

use App\Blog\Post\Author\Domain\Entity\Author;
use App\Blog\Post\Author\Domain\Repository\AuthorRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class CreateAuthorCommandHandler
{
    public function __construct(private AuthorRepositoryInterface $authorRepository)
    {
    }

    public function __invoke(CreateAuthorCommand $command): Author
    {
        $author = (new Author())
            ->setEmail($command->email)
            ->setName($command->name)
            ->setSurname($command->surname);

        $this->authorRepository->save($author);

        return $author;
    }
}
