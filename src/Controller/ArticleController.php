<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Service\CommentService;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    #[Route('/article/{slug}', name: 'article_show')]
    public function show(?Article $article,CommentService $commentService): Response
    {
        if (!$article) {
            return $this->redirectToRoute('home');
        }

        $parameters = [
            'article' => $article,
            'comments' =>  $commentService->getPaginatedComments($article)
        ];

        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            $commentForm = $this->createForm(CommentType::class,  new Comment($article, $this->getUser()));
            $parameters['commentForm'] = $commentForm;

        }

        return $this->renderForm('articles/show.html.twig', $parameters);
    }
}
