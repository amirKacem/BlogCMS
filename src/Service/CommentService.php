<?php

namespace App\Service;

use App\Entity\Article;
use App\Repository\CommentRepository;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class CommentService
{
    public function __construct(
        private RequestStack $requestStack,
        private CommentRepository $commentRepository,
        private PaginatorInterface $paginator
    )
    {
    }


    public function getPaginatedComments(?Article $article = null)
    {
        $request =  $this->requestStack->getMainRequest();
        $page = $request->get('page',1);
        $limit = 2;
        $commentsQuery = $this->commentRepository->findForPagination($article);
        return $this->paginator->paginate($commentsQuery,$page,$limit);
    }

}