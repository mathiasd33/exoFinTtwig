<?php

namespace App\Controller\admin;


use App\Entity\Category;
use App\Repository\CatagoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function insertCategorie(EntityManagerInterface $entityManager)
    {
        //création d'une catégorie
        $category = new Category();

        //setters pour renseigner la valeur des colonnes

        $category->setTitle('titre categorie');
        $category->setDescription('contenue de la categorie');


        //sauvegarde entité
        $entityManager->persist($category);

        //récupération des entitées pour les inserer en bdd
        $entityManager->flush();

        return $this->redirectToRoute('admin_categorie_list');

    }

    /**
     * @Route ("/admin/categories/update/{id}",name="admin_categorie_update")
     */
    public function updateCategorie($id, CatagoryRepository  $catagoryRepository, EntityManagerInterface $entityManager)
    {
        $category = $catagoryRepository->find($id);
        if ($category)
        {
            $category->setTitle("nouveau titre");
            $entityManager->persist($category);
            $entityManager->flush();

        }
        return $this->redirectToRoute('admin_categorie_list');
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

        }
        return $this->redirectToRoute('admin_categorie_list');
    }





}



