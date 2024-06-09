<?php

declare(strict_types=1);

namespace App\Blog\Post\Author\Domain\Repository;

use App\Blog\Post\Author\Domain\Entity\Author;
use Doctrine\DBAL\LockMode;

interface AuthorRepositoryInterface
{
    public function find(int $id, LockMode|int|null $lockMode = null, ?int $lockVersion = null): ?Author;

    public function findByEmail(string $email): ?Author;

    /**
     * @param int $articleId
     * @return Author[]
     */
    public function findAllByArticleId(int $articleId): array;

    /**
     * @param string $email
     * @return Author[]
     */
    public function findAllByEmail(string $email): array;

    public function save(Author $author): void;
}
