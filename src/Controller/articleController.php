<?php


namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class articleController extends AbstractController
{
    /**
     * @Route ("/articles", name="article_list")
     */

    public function articles_list(articleRepository $articleRepository)
    {
        $articles = $articleRepository->findAll();

        return $this->render('articles_list.html.twig', [
            'articles' => $articles
        ]);
    }



    /**
     * @Route ("/article/{id}", name="articleShow")
     */

    public function articleShow($id, ArticleRepository $articleRepository)
    {
        $article = $articleRepository->find($id);

        if (is_null($article)){
            throw new NotFoundHttpException();
        }

        return $this->render("articleShow.html.twig", [
            'article' => $article
        ]);
    }


    /**
     * @Route("/search", name="search")
     */

    public function search(ArticleRepository $articleRepository)
    {
        //  recherche de l'utilisateur (
        $term = 'skate';

        //  récupère le contenu de la recherche
        $articles = $articleRepository->searchByTerm($term);

        //  affiche les résultats
        return $this->render('articleSearch.html.twig', [
            'articles' => $articles
        ]);
    }
}