<?php

declare(strict_types=1);

namespace App\Blog\Post\Article\Infrastructure;

use App\Blog\Post\Article\Domain\Entity\Article;
use App\Blog\Post\Article\Domain\Repository\ArticleRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

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

    public function findPaginatedArticles(int $page, int $limit): Paginator
    {
        $query = $this->createQueryBuilder('a')
            ->orderBy('a.created_at', 'DESC')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
            ->getQuery();

        return new Paginator($query, true);
    }

    public function findPaginatedArticlesWithAuthor(int $page = 1, int $limit = 10): array
    {
        $offset = ($page - 1) * $limit;
        $articlesQuery = $this->createQueryBuilder('a')
            ->select('a, au')
            ->innerJoin('a.author', 'au')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
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
