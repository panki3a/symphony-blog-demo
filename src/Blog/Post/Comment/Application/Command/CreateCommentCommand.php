<?php

declare(strict_types=1);

namespace App\Blog\Post\Comment\Application\Command;

final readonly class CreateCommentCommand
{
    public function __construct(
        public int $articleId,
        public string $content,
        public string $userEmail,
        public string $userName,
        public string $userSurname,
    ) {
    }
}
