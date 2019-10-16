<?php

namespace App\Controller;

use App\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
    public function create(Article $article = null, Request $request, ObjectManager $manager)
    {
        if(!$article){
            $article = new Article();
        }

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            if(!$article->getId()) {
                $article->setCreatedAt(new \DateTime());
            }

            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('showarticle', ['id' => $article->getId()]);
        }

        return $this->render('articles/new.html.twig', [
            'formArticle' => $form->createView()
        ]);
    }

    /**
    * @Route("/articles/edit/{id}", name="editarticle")
    */
    public function edit(Article $article, Request $request, ObjectManager $manager)
    {
        if(!$article){
            return $this->render('index.html.twig');
        }

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('showarticle', ['id' => $article->getId()]);
        }

        return $this->render('articles/edit.html.twig', [
            'formArticle' => $form->createView()
        ]);
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
}
