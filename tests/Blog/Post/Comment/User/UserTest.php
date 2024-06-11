<?php

declare(strict_types=1);

namespace App\Tests\Blog\Post\Comment\User;

use App\Blog\Post\Comment\Domain\Entity\Comment;
use App\Blog\Post\Comment\User\Domain\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        $this->user = new User();
    }

    public function testUserCanSetAndGetId(): void
    {
        $user = new User();
        $user->setId(1);
        $this->assertSame(1, $user->getId());
    }

    public function testUserCanSetAndGetEmail(): void
    {
        $user = new User();
        $user->setEmail('test@example.com');
        $this->assertSame('test@example.com', $user->getEmail());
    }

    public function testUserCanSetAndGetName(): void
    {
        $user = new User();
        $user->setName('John');
        $this->assertSame('John', $user->getName());
    }

    public function testUserCanSetAndGetSurname(): void
    {
        $user = new User();
        $user->setSurname('Doe');
        $this->assertSame('Doe', $user->getSurname());
    }

    public function testUserCanSetAndGetCreatedAt(): void
    {
        $user = new User();
        $dateTime = new \DateTimeImmutable();
        $user->setCreatedAt($dateTime);
        $this->assertSame($dateTime, $user->getCreatedAt());
    }

    public function testUserCanSetAndGetUpdatedAt(): void
    {
        $user = new User();
        $dateTime = new \DateTimeImmutable();
        $user->setUpdatedAt($dateTime);
        $this->assertSame($dateTime, $user->getUpdatedAt());
    }

    public function testUserCanAddAndRemoveComment(): void
    {
        $user = new User();
        $comment = new Comment();
        $user->addComment($comment);
        $this->assertSame($comment, $user->getComments()->first());

        $user->removeComment($comment);
        $this->assertFalse($user->getComments()->contains($comment));
    }

}
