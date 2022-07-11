<?php

namespace App\Controller;

use App\Entity\Article;
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
        return $this->render('articles/show.html.twig', [
            'article' => $article,
        ]);
    }
}
