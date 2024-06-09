<?php

declare(strict_types=1);

namespace App\Blog\Post\Comment\Infrastructure;

use App\Blog\Post\Comment\Domain\Entity\Comment;
use App\Blog\Post\Comment\Domain\Repository\CommentRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\LockMode;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Comment>
 */
class CommentRepository extends ServiceEntityRepository implements CommentRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    public function find(mixed $id, LockMode|int|null $lockMode = null, ?int $lockVersion = null): Comment|null
    {
        return parent::find($id, $lockMode, $lockVersion);
    }

    public function save(Comment $comment): void
    {
        $this->getEntityManager()->persist($comment);
        $this->getEntityManager()->flush();
    }

    public function countByArticle(int $articleId): int
    {
        return $this->createQueryBuilder('c')
            ->select('COUNT(c.id)')
            ->where('c.article = :articleId')
            ->setParameter('articleId', $articleId)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findAllByArticleId(int $articleId): array
    {
        return $this->createQueryBuilder('c')
            ->where('c.article = :articleId')
            ->setParameter('articleId', $articleId)
            ->getQuery()
            ->getResult();
    }

    public function countsByArticlesIds(array $articlesIds): array
    {
        $query = $this->createQueryBuilder('c')
            ->select('a.id as articleId, COUNT(c.id) AS commentsCount')
            ->join('c.article', 'a')
            ->where('a IN (:articles)')
            ->setParameter('articles', $articlesIds)
            ->groupBy('a.id')
            ->getQuery();


        return $query->getResult();
    }
}
