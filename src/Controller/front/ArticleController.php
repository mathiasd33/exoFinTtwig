<?php


namespace App\Controller\front;


use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{

    /**
     * @Route("/search", name="search")
     */

    public function search(ArticleRepository $articleRepository, request $request)
    {
        //  recherche de l'utilisateur (
        $term = $request->query->get('q');

        //  récupère le contenu de la recherche
        $articles = $articleRepository->searchByTerm($term);

        //  affiche les résultats
        return $this->render('front/article_search.html.twig', [
            'articles' => $articles,
            'term' => $term
        ]);
    }
    /**
     * @Route ("/front/articles", name="article_list")
     */

    public function articles_list(articleRepository $articleRepository)
    {
        $articles = $articleRepository->findAll();

        return $this->render('front/article_list.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route ("/front/article/{id}", name="article_show")
     */

    public function articles_show($id, articleRepository $articleRepository)
    {
        $articles = $articleRepository->find($id);

        return $this->render('front/article_show.html.twig', [
            'article' => $articles
        ]);
    }

}