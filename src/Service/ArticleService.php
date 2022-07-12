<?php

namespace App\Service;

use App\Entity\Category;
use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class ArticleService
{
    public function __construct(
        private RequestStack $requestStack,
        private ArticleRepository $articleRepository,
        private PaginatorInterface $paginator
    )
    {
    }

    public function getPaginatedArticles(?Category $category = null)
    {
        $request =  $this->requestStack->getMainRequest();
        $page = $request->get('page',1);
        $limit = 2;
        $articleQuery = $this->articleRepository->findForPagination($category);
        return $this->paginator->paginate($articleQuery,$page,$limit);
    }
}