<?php


namespace App\Controller\admin;

use App\Entity\Article;
use App\Entity\Tag;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Repository\CatagoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ArticleController extends AbstractController
{



     /**
     * @Route ("/admin/articles/insert",name="admin_article_insert")
     */
     public function insertArticle( Request $request, EntityManagerInterface $entityManager,SluggerInterface $slugger) : Response
     {
         $article = new Article();
         //on génère le formulaire en utilisant le gabarit + une instance de l entité Article
         $articleForm = $this->createForm(ArticleType::class, $article);


         // on lie le formulaire aux données de POST
         $articleForm->handleRequest($request);

         if ($articleForm->isSubmitted()&&$articleForm->isValid()){
             $imageFile = $articleForm->get('image')->getData();

         if ($imageFile){
             $originalFilename = pathinfo($imageFile->getClientOriginalName(),PATHINFO_FILENAME);
             $safeFilename = $slugger->slug($originalFilename);
             $newFilename = $safeFilename .'_'.uniqid().'.'.$imageFile->guessExtension();

             try {
                 $imageFile->move(
                     $this->getParameter('upload_directory'),
                     $newFilename
                 );
             } catch (FileException $exception) {
                 // ... handle exception if something happens during file upload
             }

             $article->setImage($newFilename);
         }


             $this->addFlash(
                 'succes',
                 'Votre article '. $article->getTitle().' à bien été créé !'
             );
               $entityManager->persist($article);
               $entityManager->flush();

               return $this->redirectToRoute('admin_article_list');
         }

         return $this->render('admin/insertArticle.html.twig',[
            'articleForm' =>$articleForm->createView()
         ]);
     }


//    public function insertArticle(EntityManagerInterface $entityManager, CatagoryRepository $catagoryRepository)
//    {
//        //création d'un article
//        $article = new Article();
//
//        //setters pour renseigner la valeur des colonnes
//
//        $article->setTitle('titre article');
//        $article->setContent('contenue de l article');
//        $article->setIsPublished('true');
//        $article->setCreatedAt(new \DateTime('NOW'));
//
//        //je recupere la catégorie est 1 en bdd
//        //doctrine créé une instance de l'entité categorie avec les infos de la categorie de la bdd
//        $category = $catagoryRepository->find(1);
//
//        //j'associe l instance de l' entité categorie récupéré a l instance de l'entité article que je suis
//        //en train de créer
//        $article->setCategory($category);
//
//        //création nouveau tag
//        $tag = new Tag();
//        $tag->setTitle("info");
//        $tag->setColor("blue");
//
//        $entityManager->persist($tag);
//
//        $article->setTag($tag);
//
//
//        //sauvegarde entité
//        $entityManager->persist($article);
//
//        //récupération des entitées pour les inserer en bdd
//        $entityManager->flush();
//
//        return $this->redirectToRoute('admin_article_list');
//
//    }

    /**
     * @Route ("/admin/articles/update/{id}",name="admin_article_update")
     */
    public function updateArticle($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager, Request $request)
    {
        $article = $articleRepository->find($id);
        //on génère le formulaire en utilisant le gabarit + une instance de l entité Article
        $articleForm = $this->createForm(ArticleType::class, $article);

        // on lie le formulaire aux données de POST
        $articleForm->handleRequest($request);

        if ($articleForm->isSubmitted()&&$articleForm->isValid()){

            $this->addFlash(
                'succes',
                'Votre article '. $article->getTitle().' a bien été modifié !'
            );

            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('admin_article_list');
        }

        return $this->render('admin/insertArticle.html.twig',[
            'articleForm' =>$articleForm->createView()
        ]);

//
//           if ($article)
//           {
//               $article->setTitle("nouveau titre");
//               $entityManager->persist($article);
//               $entityManager->flush();
//
//           }
//           return $this->redirectToRoute('admin_article_list');
    }


    /**
     * @Route ("/admin/articles/delete/{id}",name="admin_article_delete")
     */
    public function deleteArticle($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager)
    {

        $article = $articleRepository->find($id);
        $entityManager->remove($article);
        $entityManager->flush();
        $this->addFlash(
            'succes',
            'Votre article '. $article->getTitle().' a bien été supprimé !'
        );

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

    /**
     * @Route ()
     */
    public function new(Request $request, SluggerInterface $slugger){

    }
}