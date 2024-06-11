<?php

declare(strict_types=1);

namespace App\Blog\Post\Article\Infrastructure;

use App\Blog\Post\Article\Domain\Entity\Article;
use App\Blog\Post\Article\Domain\Repository\ArticleRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\LockMode;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 */
class ArticleRepository extends ServiceEntityRepository implements ArticleRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function find(mixed $id, LockMode|int|null $lockMode = null, ?int $lockVersion = null): ?Article
    {
        return parent::find($id, $lockMode, $lockVersion);
    }

    public function save(Article $article): void
    {
        $this->getEntityManager()->persist($article);
        $this->getEntityManager()->flush();
    }

    public function findPaginatedArticlesWithAuthor(int $page = 1, int $limit = 10): array
    {
        $offset = ($page - 1) * $limit;
        $articlesQuery = $this->createQueryBuilder('a')
            ->select('a, au')
            ->innerJoin('a.author', 'au')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->orderBy('a.created_at ', 'DESC')
            ->getQuery();

        $articles = $articlesQuery->getResult();

        $totalArticlesQuery = $this->createQueryBuilder('a')
            ->select('COUNT(a.id)')
            ->getQuery();

        $totalArticles = $totalArticlesQuery->getSingleScalarResult();

        return [
            'data' => $articles,
            'total' => $totalArticles,
            'page' => $page,
            'limit' => $limit,
        ];
    }
}
