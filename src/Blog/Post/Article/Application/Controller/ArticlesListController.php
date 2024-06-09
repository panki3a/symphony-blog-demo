<?php

declare(strict_types=1);

namespace App\Blog\Post\Article\Application\Controller;

use App\Blog\Post\Article\Application\Query\FindArticlesByPageQuery;
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

    public function __construct(MessageBusInterface $messageBus, private LoggerInterface $logger)
    {
        $this->messageBus = $messageBus;
    }

    #[Route('/articles', name: 'articles_list', methods: ['GET'])]
    public function __invoke(Request $request, int $articleLimit): Response
    {
        try {
            $page = $request->query->getInt('page', 1);

            $articlesPaginator = $this->handle(new FindArticlesByPageQuery($page, $articleLimit));


dump($articlesPaginator);


            $articleIds = array_map(fn ($article) => $article->getId(), $articles);
            $commentsCountMap = array_column($commentsCounts, 'commentsCount', 'id');
            array_walk($articles, fn ($article) => $article->setCommentsCount($commentsCountMap[$article->getId()] ?? 0));
exit;
            return $this->render(
                'blog/post/article/application/controller/articles_list/index.html.twig',
                [
//                    'articles' => $articlesPaginator,
//                    'total' => count($articlesPaginator),
//                    'currentPage' => $page,
//                    'pages' => ceil(count($articlesPaginator) / $articleLimit),
                    'articles' => $articlesPaginator,
                    'total' => $articlesPaginator['total'],
                    'page' => $articlesPaginator['page'],
                    'limit' => $articlesPaginator['limit'],
                ]
            );
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            throw  $e;
            return new Response('An error occurred while processing your request.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
