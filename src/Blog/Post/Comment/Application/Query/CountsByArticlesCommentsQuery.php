<?php

declare(strict_types=1);

namespace App\Blog\Post\Comment\Application\Query;

final readonly class CountsByArticlesCommentsQuery
{
    /**
     * @param int[] $articlesId
     */
    public function __construct(public array $articlesId)
    {
    }
}
