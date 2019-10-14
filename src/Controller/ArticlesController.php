<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function create(Request $request, ObjectManager $manager)
    {
        $article = new Article();

        $form = $this->createFormBuilder($article)
                     ->add('title', TextType::class, [
                        'attr' => [
                            'placeholder' => "Titre de l'article",
                            'class' => 'form-control'
                        ]
                     ])
                     ->add('content', TextareaType::class, [
                         'attr' => [
                             'placeholder' => "Contenu de l'article",
                             'class' => 'form-control'
                         ]
                     ])
                     ->add('image', TextType::class, [
                         'attr' => [
                             'placeholder' => "Image de l'article",
                             'class' => 'form-control'
                         ]
                     ])
                     ->getForm();
        return $this->render('articles/new.html.twig', [
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

    /**
     * @Route("/blog/edit/{id}", name="editarticle")
     */
    public function edit($id)
    {

    }
}
