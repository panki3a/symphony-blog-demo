<?php

declare(strict_types=1);

namespace App\Blog\Post\Comment\User\Application\Command;

final readonly class CreateUserCommand
{
    public function __construct(
        public string $email,
        public string $name,
        public string $surname,
    ) {
    }
}
