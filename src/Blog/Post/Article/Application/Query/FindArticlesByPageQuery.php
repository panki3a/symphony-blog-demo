<?php

declare(strict_types=1);

namespace App\Blog\Post\Article\Application\Query;

final readonly class FindArticlesByPageQuery
{
    public function __construct(public int $page, public int $limit = 10)
    {
    }
}
