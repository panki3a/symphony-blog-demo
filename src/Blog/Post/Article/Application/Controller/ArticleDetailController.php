<?php

declare(strict_types=1);

namespace App\Blog\Post\Article\Application\Controller;

use App\Blog\Post\Article\Application\Query\FindArticleQuery;
use App\Blog\Post\Comment\Application\Form\CommentFormType;
use App\Blog\Post\Comment\Application\Query\CommentsByArticleQuery;
use App\Blog\Post\Comment\Application\Query\CountArticleCommentsQuery;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

final class ArticleDetailController extends AbstractController
{
    use HandleTrait;

    public function __construct(
        private MessageBusInterface $messageBus,
        private readonly LoggerInterface $logger
    ) {
    }

    #[Route('/article/{articleId}-{slug}', name: 'article_detail')]
    public function __invoke(int $articleId): Response
    {
        try {
            $article = $this->handle(new FindArticleQuery($articleId));
            $commentsCount = $this->handle(new CountArticleCommentsQuery($articleId));
            $comments = $this->handle(new CommentsByArticleQuery($articleId));

            $commentForm = $this->createForm(
                type: CommentFormType::class,
                options: ['action' => $this->generateUrl('article_comment_post_detail', ['articleId' => $articleId, 'slug' => $article->getSlug()])]
            );

            return $this->render(
                'blog/post/article/application/controller/article_detail/index.html.twig',
                [
                    'article' => $article,
                    'comments' => $comments,
                    'commentsCount' => $commentsCount,
                    'commentForm' => $commentForm->createView(),
                ]
            );
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            return new Response('An error occurred while processing your request.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
