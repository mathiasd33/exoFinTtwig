<?php


namespace App\Controller\admin;

use App\Entity\Article;
use App\Entity\Tag;
use App\Repository\ArticleRepository;
use App\Repository\CatagoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{



    /**
     * @Route ("/admin/articles/insert",name="admin_article_insert")
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

        return $this->redirectToRoute('admin_article_list');

    }

    /**
     * @Route ("/admin/articles/update/{id}",name="admin_article_update")
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
           return $this->redirectToRoute('admin_article_list');
    }


    /**
     * @Route ("/admin/articles/delete/{id}",name="admin_article_delete")
     */
    public function deleteArticle($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager)
    {

        $article = $articleRepository->find($id);
        $entityManager->remove($article);
        $entityManager->flush();

        return $this->redirectToRoute('admin_article_list');
    }

    /**
     * @Route ("/admin/articles", name="admin_article_list")
     */

    public function articles_list(articleRepository $articleRepository)
    {
        $articles = $articleRepository->findAll();

        return $this->render('admin/article_list.html.twig', [
            'articles' => $articles
        ]);
    }
}