<?php

declare(strict_types=1);

namespace App\Tests\Blog\Post\Comment;

use App\Blog\Post\Article\Domain\Entity\Article;
use App\Blog\Post\Comment\Domain\Entity\Comment;
use App\Blog\Post\Comment\User\Domain\Entity\User;
use PHPUnit\Framework\TestCase;

class CommentTest extends TestCase
{
    private Comment $comment;

    protected function setUp(): void
    {
        $this->comment = new Comment();
    }

    public function testCanSetAndGetId(): void
    {
        $comment = new Comment();
        $comment->setId(1);
        $this->assertSame(1, $comment->getId());
    }

    public function testCanSetAndGetContent(): void
    {
        $comment = new Comment();
        $comment->setContent('This is a comment');
        $this->assertSame('This is a comment', $comment->getContent());
    }

    public function testCanSetAndGetCreatedAt(): void
    {
        $comment = new Comment();
        $dateTime = new \DateTimeImmutable();
        $comment->setCreatedAt($dateTime);
        $this->assertSame($dateTime, $comment->getCreatedAt());
    }

    public function testCanSetAndGetUpdatedAt(): void
    {
        $comment = new Comment();
        $dateTime = new \DateTimeImmutable();
        $comment->setUpdatedAt($dateTime);
        $this->assertSame($dateTime, $comment->getUpdatedAt());
    }

    public function testCanSetAndGetAccepted(): void
    {
        $comment = new Comment();
        $comment->setAccepted(true);
        $this->assertTrue($comment->isAccepted());
    }

    public function testCanSetAndGetUser(): void
    {
        $comment = new Comment();
        $user = new User();
        $comment->setUser($user);
        $this->assertSame($user, $comment->getUser());
    }

    public function testCanSetAndGetArticle(): void
    {
        $comment = new Comment();
        $article = new Article();
        $comment->setArticle($article);
        $this->assertSame($article, $comment->getArticle());
    }

    public function testCreatedAtIsAutomaticallySet(): void
    {
        $comment = new Comment();
        $comment->setCreatedAtValue();
        $this->assertInstanceOf(\DateTimeImmutable::class, $comment->getCreatedAt());
    }

    public function testUpdatedAtIsAutomaticallySet(): void
    {
        $comment = new Comment();
        $comment->setUpdatedAtValue();
        $this->assertInstanceOf(\DateTimeImmutable::class, $comment->getUpdatedAt());
    }
}
