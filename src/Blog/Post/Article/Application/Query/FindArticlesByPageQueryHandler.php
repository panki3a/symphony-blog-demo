<?php

declare(strict_types=1);

namespace App\Blog\Post\Article\Application\Query;

use App\Blog\Post\Article\Domain\Entity\Article;
use App\Blog\Post\Article\Domain\Repository\ArticleRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class FindArticlesByPageQueryHandler
{
    public function __construct(private ArticleRepositoryInterface $articleRepository)
    {
    }

    /**
     * @param FindArticlesByPageQuery $query
     * @return array{data: Article[], total: int, page: int, limit: int}
     */
    public function __invoke(FindArticlesByPageQuery $query): array
    {
        return $this->articleRepository->findPaginatedArticlesWithAuthor($query->page, $query->limit);
    }
}
