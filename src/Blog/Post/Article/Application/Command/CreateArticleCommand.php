<?php

declare(strict_types=1);

namespace App\Blog\Post\Article\Application\Command;

final readonly class CreateArticleCommand
{
    public function __construct(
        public string $title,
        public string $description,
        public string $content,
        public string $authorEmail,
        public string $authorName,
        public string $authorSurname,
    ) {
    }
}
