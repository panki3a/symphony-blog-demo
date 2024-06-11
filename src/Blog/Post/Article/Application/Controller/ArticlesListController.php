<?php

declare(strict_types=1);

namespace App\Blog\Post\Article\Application\Controller;

use App\Blog\Post\Article\Application\Query\FindArticlesByPageQuery;
use App\Blog\Post\Article\Domain\Entity\Article;
use App\Blog\Post\Comment\Application\Query\CountsByArticlesCommentsQuery;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

final class ArticlesListController extends AbstractController
{
    use HandleTrait;

    public function __construct(
        private MessageBusInterface $messageBus,
        private readonly LoggerInterface $logger
    ) {
    }

    #[Route('/', name: 'articles_list', methods: ['GET'])]
    public function __invoke(Request $request, int $articleLimit): Response
    {
        try {
            $page = $request->query->getInt('page', 1);

            $articlesPaginator = $this->handle(new FindArticlesByPageQuery($page, $articleLimit));

            $articleIds = array_map(fn ($article) => $article->getId(), $articlesPaginator['data']);
            $commentsCounts = $this->handle(new CountsByArticlesCommentsQuery($articleIds));

            $this->processCommentsCount($commentsCounts, $articlesPaginator['data']);

            return $this->render(
                'blog/post/article/application/controller/articles_list/index.html.twig',
                [
                    'articles' => $articlesPaginator['data'],
                    'total' => $articlesPaginator['total'],
                    'page' => $articlesPaginator['page'],
                    'limit' => $articlesPaginator['limit'],
                ]
            );
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            return new Response('An error occurred while processing your request.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param array<array{articleId: int, commentsCount: int}> $commentsCounts
     * @param Article[] $articles
     * @return void
     */
    private function processCommentsCount(array $commentsCounts, array $articles): void
    {
        $commentsCountsAssoc = array_combine(
            array_column($commentsCounts, 'articleId'),
            array_column($commentsCounts, 'commentsCount')
        );

        foreach ($articles as $article) {
            $articleId = $article->getId();
            $commentsCount = $commentsCountsAssoc[$articleId] ?? 0;
            $article->setCommentsCount($commentsCount);
        }
    }
}
