<?php


namespace App\Controller;

use App\Entity\Article;
use App\Entity\Tag;
use App\Repository\ArticleRepository;
use App\Repository\CatagoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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

    public function search(ArticleRepository $articleRepository, request $request)
    {
        //  recherche de l'utilisateur (
        $term = $request->query->get('q');

        //  récupère le contenu de la recherche
        $articles = $articleRepository->searchByTerm($term);

        //  affiche les résultats
        return $this->render('articleSearch.html.twig', [
            'articles' => $articles,
            'term' => $term
        ]);
    }

    /**
     * @Route ("/articles/insert",name="insert")
     */
    public function insertArticle(EntityManagerInterface $entityManager, CatagoryRepository $catagoryRepository)
    {
        //création d'un article
        $article = new Article();

        //setters pour renseigner la valeur des colonnes

        $article->setTitle('titre article');
        $article->setContent('contenue de l article');
        $article->setIsPublished('true');
        $article->setCreatedAt(new \DateTime('NOW'));

        //je recupere la catégorie est 1 en bdd
        //doctrine créé une instance de l'entité categorie avec les infos de la categorie de la bdd
        $category = $catagoryRepository->find(1);

        //j'associe l instance de l' entité categorie récupéré a l instance de l'entité article que je suis
        //en train de créer
        $article->setCategory($category);

        //création nouveau tag
        $tag = new Tag();
        $tag->setTitle("info");
        $tag->setColor("blue");

        $entityManager->persist($tag);

        $article->setTag($tag);


        //sauvegarde entité
        $entityManager->persist($article);

        //récupération des entitées pour les inserer en bdd
        $entityManager->flush();

        return $this->redirectToRoute('article_list');

    }

    /**
     * @Route ("/articles/update/{id}",name="update")
     */
    public function updateArticle($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager)
    {
        $article = $articleRepository->find($id);
           if ($article)
           {
               $article->setTitle("nouveau titre");
               $entityManager->persist($article);
               $entityManager->flush();

           }
           return $this->redirectToRoute('article_list');
    }
}