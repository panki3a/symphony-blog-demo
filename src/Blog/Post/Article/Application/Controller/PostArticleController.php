<?php

declare(strict_types=1);

namespace App\Blog\Post\Article\Application\Controller;

use App\Blog\Post\Article\Application\Command\CreateArticleCommand;
use App\Blog\Post\Article\Application\Form\ArticleFormType;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

final class PostArticleController extends AbstractController
{
    use HandleTrait;

    public function __construct(
        private MessageBusInterface $messageBus,
        private readonly LoggerInterface $logger
    ) {
    }

    #[Route('/post-article', name: 'article_post', methods: ['POST'])]
    public function __invoke(Request $request): Response
    {
        try {
            $form = $this->createForm(ArticleFormType::class);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $createArticleCommand = new CreateArticleCommand(
                    title: $form->get('title')->getData(),
                    description: $form->get('description')->getData(),
                    content: $form->get('content')->getData(),
                    authorEmail: $form->get('author')->get('email')->getData(),
                    authorName: $form->get('author')->get('name')->getData(),
                    authorSurname: $form->get('author')->get('surname')->getData(),
                );

                $article = $this->handle($createArticleCommand);

                $this->addFlash('success', 'Your article has been created successfully!');

                return $this->redirectToRoute(
                    'article_detail',
                    ['articleId' => $article->getId(), 'slug' => $article->getSlug()],
                    Response::HTTP_TEMPORARY_REDIRECT
                );
            }

            $this->addFlash('error', 'An error occurred while creating your article. Please try again.');

            return $this->redirectToRoute('articles_list', [], Response::HTTP_TEMPORARY_REDIRECT);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());

            return new Response('An error occurred while processing your request.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
