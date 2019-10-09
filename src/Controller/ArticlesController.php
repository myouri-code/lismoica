<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Repository\ArticleRepository;

class ArticlesController extends AbstractController
{
    /**
     * @Route("/articles", name="articles")
     */
    public function index(ArticleRepository $repo)
    {
        $articles = $repo->findAll();

        return $this->render('articles/index.html.twig', [
            'controller_name' => 'ArticlesController',
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/articles/new", name="newarticle")
     */
    public function create()
    {
        return $this->render('articles/new.html.twig');
    }

    /**
     * @Route("/articles/show/{id}", name="showarticle")
     */
    public function show(Article $article)
    {
        return $this->render('articles/show.html.twig', [
            'article' => $article
        ]);
    }

    /**
     * @Route("/article/delete/{id}", name="deletearticle")
     */
    public function delete($id)
    {

    }

    /**
     * @Route("/blog/edit/{id}", name="editarticle")
     */
    public function edit($id)
    {

    }
}
