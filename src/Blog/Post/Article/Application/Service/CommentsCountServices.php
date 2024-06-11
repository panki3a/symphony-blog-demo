<?php

declare(strict_types=1);

namespace App\Blog\Post\Article\Application\Service;

use App\Blog\Post\Article\Domain\Entity\Article;

class CommentsCountServices
{
    /**
     * @param array<array{articleId: int, commentsCount: int}> $commentsCounts
     * @param Article[] $articles
     */
    public static function processCommentsCount(array $commentsCounts, array $articles): void
    {
        $commentsCountsAssoc = array_combine(
            array_column($commentsCounts, 'articleId'),
            array_column($commentsCounts, 'commentsCount')
        );

        foreach ($articles as $article) {
            $articleId = $article->getId();
            $commentsCount = $commentsCountsAssoc[$articleId] ?? 0;
            $article->setCommentsCount($commentsCount);
        }
    }
}
