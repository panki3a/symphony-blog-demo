<?php

declare(strict_types=1);

namespace App\Blog\Post\Article\Application\Query;

use App\Blog\Post\Article\Domain\Entity\Article;
use App\Blog\Post\Article\Domain\Repository\ArticleRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class FindArticleQueryHandler
{
    public function __construct(private ArticleRepositoryInterface $articleRepository)
    {
    }

    public function __invoke(FindArticleQuery $query): Article
    {
        return $this->articleRepository->find($query->id);
    }
}
