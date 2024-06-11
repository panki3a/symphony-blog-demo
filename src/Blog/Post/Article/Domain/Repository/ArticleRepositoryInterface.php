<?php

declare(strict_types=1);

namespace App\Blog\Post\Article\Domain\Repository;

use App\Blog\Post\Article\Domain\Entity\Article;
use Doctrine\DBAL\LockMode;

interface ArticleRepositoryInterface
{
    public function find(int $id, LockMode|int|null $lockMode = null, ?int $lockVersion = null): ?Article;

    /**
     * @return Article[]
     */
    public function findAll(): array;

    /**
     * @param int $page
     * @param int $limit
     * @return array{data: Article[], total: int, page: int, limit: int}
     */
    public function findPaginatedArticlesWithAuthor(int $page, int $limit): array;

    public function save(Article $article): void;
}
