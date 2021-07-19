<?php

namespace App\Controller\admin;


use App\Entity\Category;
use App\Form\ArticleType;
use App\Form\CategoryType;
use App\Repository\CatagoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesController extends AbstractController
{


    /**
     * @Route ("/admin/categories", name="admin_categorie_list")
     */

    public function categoriesList(CatagoryRepository $catagoryRepository)
    {
        $categories = $catagoryRepository->findAll();
       return $this->render('admin/categorie_list.html.twig',[
         'categories' =>$categories
       ]);
    }

    /**
     * @Route ("/admin/categories/insert",name="admin_categorie_insert")
     */
    public function insertCategorie(Request $request, EntityManagerInterface $entityManager)
    {

        $categorie = new Category();
        //on génère le formulaire en utilisant le gabarit + une instance de l entité Article
        $categorieForm = $this->createForm(CategoryType::class, $categorie);

        // on lie le formulaire aux données de POST
        $categorieForm->handleRequest($request);

        if ($categorieForm->isSubmitted()&&$categorieForm->isValid()){
            $this->addFlash(
                'succes',
                'Votre catégorie '. $categorie->getTitle().' a bien été crée !'
            );
            $entityManager->persist($categorie);
            $entityManager->flush();
            return $this->redirectToRoute('admin_categorie_list');


        }
        return $this->render('admin/insertCategorie.html.twig',[
        'categorieForm' =>$categorieForm->createView()
    ]);
//        //création d'une catégorie
//        $category = new Category();
//
//        //setters pour renseigner la valeur des colonnes
//
//        $category->setTitle('titre categorie');
//        $category->setDescription('contenue de la categorie');
//
//
//        //sauvegarde entité
//        $entityManager->persist($category);
//
//        //récupération des entitées pour les inserer en bdd
//        $entityManager->flush();

    }

    /**
     * @Route ("/admin/categories/update/{id}",name="admin_categorie_update")
     */
    public function updateCategorie($id, CatagoryRepository  $catagoryRepository, EntityManagerInterface $entityManager, Request $request)
    {
        $categorie = $catagoryRepository->find($id);

        //on génère le formulaire en utilisant le gabarit + une instance de l entité Article
        $categorieForm = $this->createForm(CategoryType::class, $categorie);

        // on lie le formulaire aux données de POST
        $categorieForm->handleRequest($request);

        if ($categorieForm->isSubmitted() && $categorieForm->isValid()){
            $this->addFlash(
                'succes',
                'Votre catégorie '. $categorie->getTitle().' a bien été modifiée !'
            );
            $entityManager->persist($categorie);
            $entityManager->flush();
            return $this->redirectToRoute('admin_categorie_list');


        }
        return $this->render('admin/insertCategorie.html.twig',[
            'categorieForm' =>$categorieForm->createView()]);


//        $category = $catagoryRepository->find($id);
//        if ($category)
//        {
//            $category->setTitle("nouveau titre");
//            $entityManager->persist($category);
//            $entityManager->flush();
//
//        }
//        return $this->redirectToRoute('admin_categorie_list');
   }

    /**
     * @Route ("/admin/categories/delete/{id}",name="admin_categorie_delete")
     */
    public function deleteCategorie($id, CatagoryRepository  $catagoryRepository, EntityManagerInterface $entityManager)
    {
        $category = $catagoryRepository->find($id);
        if ($category)
        {
            $category->setTitle("nouveau titre");
            $entityManager->remove($category);
            $entityManager->flush();
            $this->addFlash(
                'succes',
                'Votre catégorie '. $category->getTitle().' a bien été supprimée !'
            );

        }
        return $this->redirectToRoute('admin_categorie_list');
    }





}



