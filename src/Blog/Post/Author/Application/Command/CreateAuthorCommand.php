<?php

declare(strict_types=1);

namespace App\Blog\Post\Author\Application\Command;

final readonly class CreateAuthorCommand
{
    public function __construct(
        public string $email,
        public string $name,
        public string $surname,
    ) {
    }
}
