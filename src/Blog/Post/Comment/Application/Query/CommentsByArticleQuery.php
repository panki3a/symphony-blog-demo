<?php

declare(strict_types=1);

namespace App\Blog\Post\Comment\Application\Query;

final readonly class CommentsByArticleQuery
{
    public function __construct(public int $articleId)
    {
    }
}
