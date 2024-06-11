<?php

declare(strict_types=1);

namespace App\Tests\Blog\Post\Article;

use App\Blog\Post\Article\Domain\Entity\Article;
use App\Blog\Post\Author\Domain\Entity\Author;
use App\Blog\Post\Comment\Domain\Entity\Comment;
use PHPUnit\Framework\TestCase;

class ArticleTest extends TestCase
{
    public function testArticleCanSetAndGetId(): void
    {
        $article = new Article();
        $article->setId(1);
        $this->assertSame(1, $article->getId());
    }

    public function testArticleCanSetAndGetSlug(): void
    {
        $article = new Article();
        $article->setSlug('test-slug');
        $this->assertSame('test-slug', $article->getSlug());
    }

    public function testArticleCanSetAndGetTitle(): void
    {
        $article = new Article();
        $article->setTitle('Test Title');
        $this->assertSame('Test Title', $article->getTitle());
    }

    public function testArticleCanSetAndGetDescription(): void
    {
        $article = new Article();
        $article->setDescription('Test Description');
        $this->assertSame('Test Description', $article->getDescription());
    }

    public function testArticleCanSetAndGetContent(): void
    {
        $article = new Article();
        $article->setContent('Test Content');
        $this->assertSame('Test Content', $article->getContent());
    }

    public function testArticleCanSetAndGetCreatedAt(): void
    {
        $article = new Article();
        $dateTime = new \DateTimeImmutable();
        $article->setCreatedAt($dateTime);
        $this->assertSame($dateTime, $article->getCreatedAt());
    }

    public function testArticleCanSetAndGetUpdatedAt(): void
    {
        $article = new Article();
        $dateTime = new \DateTimeImmutable();
        $article->setUpdatedAt($dateTime);
        $this->assertSame($dateTime, $article->getUpdatedAt());
    }

    public function testArticleCanSetAndGetAuthor(): void
    {
        $article = new Article();
        $author = new Author();
        $article->setAuthor($author);
        $this->assertSame($author, $article->getAuthor());
    }

    public function testArticleCanAddAndRemoveComment(): void
    {
        $article = new Article();
        $comment = new Comment();
        $article->addComment($comment);
        $this->assertSame($comment, $article->getComments()->first());
        $article->removeComment($comment);
        $this->assertFalse($article->getComments()->contains($comment));
    }

    public function testArticleCanSetAndGetCommentsCount(): void
    {
        $article = new Article();
        $article->setCommentsCount(5);
        $this->assertSame(5, $article->getCommentsCount());
    }
}
