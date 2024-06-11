<?php

declare(strict_types=1);

namespace App\Tests\Blog\Post\Author;

use App\Blog\Post\Article\Domain\Entity\Article;
use App\Blog\Post\Author\Domain\Entity\Author;
use PHPUnit\Framework\TestCase;

class AuthorTest extends TestCase
{
    public function testAuthorCanSetAndGetId(): void
    {
        $author = new Author();
        $author->setId(1);
        $this->assertSame(1, $author->getId());
    }

    public function testAuthorCanSetAndGetEmail(): void
    {
        $author = new Author();
        $author->setEmail('test@example.com');
        $this->assertSame('test@example.com', $author->getEmail());
    }

    public function testAuthorCanSetAndGetName(): void
    {
        $author = new Author();
        $author->setName('John');
        $this->assertSame('John', $author->getName());
    }

    public function testAuthorCanSetAndGetSurname(): void
    {
        $author = new Author();
        $author->setSurname('Doe');
        $this->assertSame('Doe', $author->getSurname());
    }

    public function testAuthorCanSetAndGetCreatedAt(): void
    {
        $author = new Author();
        $dateTime = new \DateTimeImmutable();
        $author->setCreatedAt($dateTime);
        $this->assertSame($dateTime, $author->getCreatedAt());
    }

    public function testAuthorCanSetAndGetUpdatedAt(): void
    {
        $author = new Author();
        $dateTime = new \DateTimeImmutable();
        $author->setUpdatedAt($dateTime);
        $this->assertSame($dateTime, $author->getUpdatedAt());
    }

    public function testAuthorCanAddArticle(): void
    {
        $author = new Author();
        $article = new Article();
        $author->addArticle($article);
        $this->assertSame($article, $author->getArticles()->first());
    }
}
