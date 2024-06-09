<?php

declare(strict_types=1);

namespace App\Blog\Post\Comment\Infrastructure;

use App\Blog\Post\Comment\Domain\Entity\Comment;
use App\Blog\Post\Comment\Domain\Repository\CommentRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\LockMode;
use Doctrine\Persistence\ManagerRegistry;

class CommentRepository extends ServiceEntityRepository implements CommentRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    public function find(mixed $id, LockMode|int|null $lockMode = null, int|null $lockVersion = null): ?Comment
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

    public function getCountByArticles(array $articleIds): array
    {
        $commentsCountQuery = $this->createQueryBuilder('a')
            ->select('a.id, COUNT(c.id) AS commentsCount')
            ->leftJoin('a.comments', 'c')
            ->where('a.id IN (:articleIds)')
            ->setParameter('articleIds', $articleIds)
            ->groupBy('a.id')
            ->getQuery();

        $commentsCounts = $commentsCountQuery->getResult();

        // Map comments count to articles

        return $commentsCounts;
    }

}
