<?php

declare(strict_types=1);

namespace App\Blog\Post\Comment\Application\Query;

use App\Blog\Post\Comment\Domain\Repository\CommentRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class CountsByArticlesCommentsQueryHandler
{
    public function __construct(private CommentRepositoryInterface $commentRepository)
    {
    }

    /**
     * @param CountsByArticlesCommentsQuery $query
     * @return int[]
     */
    public function __invoke(CountsByArticlesCommentsQuery $query): array
    {
        return $this->commentRepository->countsByArticlesIds($query->articlesId);
    }
}
