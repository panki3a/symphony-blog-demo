<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Blog\Post\Article\Domain\Entity\Article;
use App\Blog\Post\Author\Domain\Entity\Author;
use App\Blog\Post\Comment\Domain\Entity\Comment;
use App\Blog\Post\Comment\User\Domain\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\String\Slugger\AsciiSlugger;

class BlogPostsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $article = new Article();
            $article->setTitle($faker->realText(50, 1));
            $article->setDescription($faker->realText(255, 1));
            $article->setContent($faker->realText(600, 5));
            $article->setPublishedAt(new \DateTimeImmutable());
            $article->setSlug((new AsciiSlugger())->slug($article->getTitle())->__toString());

            $author = new Author();
            $author->setName($faker->firstName);
            $author->setSurname($faker->lastName);
            $author->setEmail($faker->email);
            $manager->persist($author);

            $article->setAuthor($author);

            for ($j = 0; $j < 10; $j++) {
                $user = new User();
                $user->setEmail($faker->email);
                $user->setName($faker->firstName);
                $user->setSurname($faker->lastName);
                $manager->persist($user);

                $comment = new Comment();
                $comment->setUser($user);
                $comment->setContent($faker->realText(150, 2));
                $comment->setAccepted(true);
                $manager->persist($comment);

                $article->addComment($comment);
            }
            $manager->persist($article);
        }

        $manager->flush();
    }
}
