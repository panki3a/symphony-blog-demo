<?php

declare(strict_types=1);

namespace App\Blog\Post\Comment\Application\Query;

use App\Blog\Post\Comment\Domain\Repository\CommentRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class CountArticleCommentsQueryHandler
{
    public function __construct(private CommentRepositoryInterface $commentRepository)
    {
    }

    public function __invoke(CountArticleCommentsQuery $query): int
    {
        return $this->commentRepository->countByArticle($query->articleId);
    }
}
