<?php

declare(strict_types=1);

namespace App\Blog\Post\Article\Application\Controller;

use App\Blog\Post\Article\Application\Form\ArticleFormType;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class NewArticleController extends AbstractController
{
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    #[Route('/new-article', name: 'new-article', methods: ['GET'])]
    public function __invoke(): Response
    {
        try {
            $articleForm = $this->createForm(
                type: ArticleFormType::class,
                options: ['action' => $this->generateUrl('article_post')]
            );

            return $this->render(
                'blog/post/article/application/controller/new_article/index.html.twig',
                [
                    'articleForm' => $articleForm->createView(),
                ]
            );
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            return new Response('An error occurred while processing your request.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
