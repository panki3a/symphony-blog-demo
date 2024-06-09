<?php

declare(strict_types=1);

namespace App\Blog\Post\Comment\User\Application\Command;

use App\Blog\Post\Comment\User\Domain\Entity\User;
use App\Blog\Post\Comment\User\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class CreateUserCommandHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {
    }

    public function __invoke(CreateUserCommand $command): User
    {
        $user = (new User())
            ->setEmail($command->email)
            ->setName($command->name)
            ->setSurname($command->surname);

        $this->userRepository->save($user);

        return $user;
    }
}
