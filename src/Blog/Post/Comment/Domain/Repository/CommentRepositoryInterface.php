<?php

declare(strict_types=1);

namespace App\Blog\Post\Comment\Domain\Repository;

use App\Blog\Post\Article\Domain\Entity\Article;
use App\Blog\Post\Comment\Domain\Entity\Comment;
use Doctrine\DBAL\LockMode;

interface CommentRepositoryInterface
{
    public function find(int $id, LockMode|int|null $lockMode = null, ?int $lockVersion = null): ?Comment;

    public function findAllByArticleId(int $articleId): array;

    public function save(Comment $comment): void;

    public function countByArticle(int $articleId): int;
}
