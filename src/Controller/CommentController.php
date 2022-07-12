<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use App\Service\CommentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    public function __construct(
        private ArticleRepository $articleRepo,
        private CommentRepository $commentRepo,
        private CommentService    $commentService
    )
    {
    }

    #[Route('/ajax/comments', name: 'comment_add', methods: ['POST'])]
    public function addComment(Request $request): Response
    {
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->json([
                'code' => 'NOT_AUTHENTICATED'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $data = $request->request->all('comment');

        if (!$this->isCsrfTokenValid('comment-add', $data['_token'])) {
            return $this->json([
                'code' => 'INVALID_CSRF_TOKEN'
            ], Response::HTTP_BAD_REQUEST);
        }

        $article = $this->articleRepo->findOneBy(['id' => $data['article']]);

        $comment = $this->commentService->add($data, $article);

        if (!$article) {
            return $this->json([
                'code' => 'ARTICLE_NOT_FOUND'
            ], Response::HTTP_BAD_REQUEST);
        }

        $html = $this->renderView('comment/index.html.twig', [
            'comment' => $comment
        ]);

        return $this->json([
            'code' => 'COMMENT_ADDED_SUCCESSFULLY',
            'detail' => [
                'comment' => $this->commentService->normalize($comment),
                'numberOfComments' => $this->commentRepo->count(['article' => $article])
            ],
            'message' => $html,
        ]);
    }
}
