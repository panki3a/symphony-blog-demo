<?php

declare(strict_types=1);

namespace App\Blog\Post\Article\Domain\Repository;

use App\Blog\Post\Article\Domain\Entity\Article;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\Tools\Pagination\Paginator;

interface ArticleRepositoryInterface
{
    public function find(int $id, LockMode|int|null $lockMode = null, ?int $lockVersion = null): ?Article;

    public function findAll(): array;

    public function findPaginatedArticles(int $page, int $limit): Paginator;
    public function findPaginatedArticlesWithAuthor(int $page, int $limit): array;

    public function save(Article $article): void;
}
