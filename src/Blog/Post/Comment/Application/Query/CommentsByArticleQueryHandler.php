<?php

declare(strict_types=1);

namespace App\Blog\Post\Comment\Application\Query;

use App\Blog\Post\Comment\Domain\Entity\Comment;
use App\Blog\Post\Comment\Domain\Repository\CommentRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class CommentsByArticleQueryHandler
{
    public function __construct(private CommentRepositoryInterface $commentRepository)
    {
    }

    /**
     * @param CommentsByArticleQuery $query
     * @return Comment[]
     */
    public function __invoke(CommentsByArticleQuery $query): array
    {
        return $this->commentRepository->findAllByArticleId($query->articleId);
    }
}
