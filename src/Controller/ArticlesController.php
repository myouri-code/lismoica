<?php

namespace App\Controller;

use App\Form\ArticleType;
use App\Form\CommentType;
use App\Entity\Comment;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Article;
use App\Repository\ArticleRepository;

class ArticlesController extends AbstractController
{
    /**
     * @Route("/articles@", name="articles")
     */
    public function index(ArticleRepository $repo)
    {
        $articles = $repo->findAll();

        return $this->render('articles/index.html.twig', [
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
    public function show(Article $article, Request $request, ObjectManager $manager)
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $comment->setCreatedAt(new \DateTime())
                    ->setArticle($article);
            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('showarticle', ['id' => $article->getId()]);
        }

        return $this->render('articles/show.html.twig', [
            'article' => $article,
            'commentForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/articles/{categoryTitle}",name="showByCateg")
     */
    public function showByCategory(ArticleRepository $articleRepo, CategoryRepository $categoryRepo, $categoryTitle){

        $category = $categoryRepo->findOneBy([
            'title' => $categoryTitle
        ]);

        $articles = $articleRepo->findBy([
            'category' => $category
        ]);

        return $this->render('articles/showByCateg', [
            'articles' =>$articles
        ]);
    }

    /**
     * @Route("/article/delete/{id}", name="deletearticle")
     */
    public function delete($id)
    {

    }
}
