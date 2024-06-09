<?php

declare(strict_types=1);

namespace App\Blog\Post\Comment\User\Domain\Repository;

use App\Blog\Post\Comment\User\Domain\Entity\User;
use Doctrine\DBAL\LockMode;

interface UserRepositoryInterface
{
    public function find(int $id, LockMode|int|null $lockMode = null, ?int $lockVersion = null): ?User;

    /**
     * @return User[]
     */
    public function findAll(): array;

    public function findByEmail(string $email): ?User;

    public function save(User $user): void;
}
