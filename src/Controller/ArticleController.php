<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\CommentType;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    #[Route('/article/{slug}', name: 'article_show')]
    public function show(?Article $article): Response
    {
        if(!$article){
            return $this->redirectToRoute('home');
        }
        $comment = new Comment($article);
        $commentForm = $this->createForm(CommentType::class,$comment);
        return $this->renderForm('articles/show.html.twig', [
            'article' => $article,
            'commentForm' => $commentForm
        ]);
    }
}
