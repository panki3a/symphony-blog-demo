<?php

declare(strict_types=1);

namespace App\Blog\Post\Article\Application\Query;

use App\Blog\Post\Article\Domain\Repository\ArticleRepositoryInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class FindArticlesByPageQueryHandler
{
    public function __construct(private ArticleRepositoryInterface $articleRepository)
    {
    }

    public function __invoke(FindArticlesByPageQuery $query): array
    {
        return $this->articleRepository->findPaginatedArticles($query->page, $query->limit);
    }
}
