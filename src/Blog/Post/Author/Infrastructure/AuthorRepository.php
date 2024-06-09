<?php

declare(strict_types=1);

namespace App\Blog\Post\Author\Infrastructure;

use App\Blog\Post\Author\Domain\Entity\Author;
use App\Blog\Post\Author\Domain\Repository\AuthorRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\LockMode;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Author>
 */
class AuthorRepository extends ServiceEntityRepository implements AuthorRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

    public function find(mixed $id, LockMode|int|null $lockMode = null, ?int $lockVersion = null): Author|null
    {
        return parent::find($id, $lockMode, $lockVersion);
    }

    public function findByEmail(string $email): Author|null
    {
        return $this->findOneBy(['email' => $email]);
    }

    public function save(Author $author): void
    {
        $this->getEntityManager()->persist($author);
        $this->getEntityManager()->flush();
    }

    public function findAllByArticleId(int $articleId): array
    {
        return $this->findBy(['article_id' => $articleId]);
    }

    public function findAllByEmail(string $email): array
    {
        return $this->findBy(['email' => $email]);
    }
}
