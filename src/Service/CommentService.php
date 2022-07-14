<?php

namespace App\Service;

use App\Entity\Article;
use App\Entity\Comment;
use App\Model\WelcomeModel;
use App\Repository\CommentRepository;

use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Security;

class CommentService
{
    public function __construct(
        private RequestStack $requestStack,
        private CommentRepository $commentRepository,
        private PaginatorInterface $paginator,
        private OptionService $optionService,
        private Security $security,
        private EntityManagerInterface $em
    )
    {
    }


    public function getPaginatedComments(?Article $article = null)
    {
        $request =  $this->requestStack->getMainRequest();
        $page = $request->get('page',1);
        $limit = $this->optionService->getValue('blog_articles_limit');
        $commentsQuery = $this->commentRepository->findForPagination($article);
        return $this->paginator->paginate($commentsQuery,$page,$limit);
    }

    public function add($data,Article $article)
    {
        $comment = new Comment($article,$this->security->getUser());
        $comment->setContent($data['content']);
        $comment->setCreatedAt(new \DateTime());

        $this->em->persist($comment);
        $this->em->flush();

        return $comment;

    }

}