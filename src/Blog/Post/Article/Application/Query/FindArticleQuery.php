<?php

declare(strict_types=1);

namespace App\Blog\Post\Article\Application\Query;

final readonly class FindArticleQuery
{
    public function __construct(public int $id)
    {
    }
}
