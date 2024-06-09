<?php

declare(strict_types=1);

namespace App\Blog\Post\Comment\Application\Controller;

use App\Blog\Post\Comment\Application\Command\CreateCommentCommand;
use App\Blog\Post\Comment\Application\Form\CommentFormType;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

final class PostCommentController extends AbstractController
{
    use HandleTrait;

    public function __construct(MessageBusInterface $messageBus, readonly private LoggerInterface $logger)
    {
        $this->messageBus = $messageBus;
    }

    #[Route('/post-comment/{articleId}-{slug}', name: 'article_comment_post_detail', methods: ['POST'])]
    public function __invoke(Request $request, int $articleId, string $slug): Response
    {
        try {
            $form = $this->createForm(CommentFormType::class);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $createCommentCommand = new CreateCommentCommand(
                    articleId: $articleId,
                    content: $form->get('content')->getData(),
                    userEmail: $form->get('user')->get('email')->getData(),
                    userName: $form->get('user')->get('name')->getData(),
                    userSurname: $form->get('user')->get('surname')->getData(),
                );
                $comment = $this->handle($createCommentCommand);
                $this->addFlash('success', 'Your comment has been posted successfully!');
            } else {
                $this->addFlash('error', 'An error occurred while posting your comment. Please try again.');
            }
            return $this->redirectToRoute('article_detail', compact('articleId', 'slug'), Response::HTTP_TEMPORARY_REDIRECT);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            throw $e;
            return new Response('An error occurred while processing your request.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
