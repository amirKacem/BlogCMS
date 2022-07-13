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
        private PaginatorInterface $paginator,
        private OptionService $optionService
    )
    {
    }

    public function getPaginatedArticles(?Category $category = null)
    {
        $request =  $this->requestStack->getMainRequest();
        $page = $request->get('page',1);
        $limit = $this->optionService->getValue('blog_articles_limit');
        $articleQuery = $this->articleRepository->findForPagination($category);
        return $this->paginator->paginate($articleQuery,$page,$limit);
    }
}