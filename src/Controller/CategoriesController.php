<?php

namespace App\Controller;

use App\Repository\CatagoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesController extends AbstractController
{


    /**
     * @Route ("/categories", name="categories")
     */

    public function categoriesList(CatagoryRepository $catagoryRepository)
    {
        $categories = $catagoryRepository->findAll();
       return $this->render('categories_list.html.twig',[
         'categories' =>$categories
       ]);
    }



    /**
     * @Route ("/categorie/{id}", name="categorieShow")
     */

    public function categorieShow($id, CatagoryRepository $catagoryRepository)
    {
        $categorie = $catagoryRepository->find($id);
        return $this->render("categorieShow.html.twig", [
           'categorie' => $categorie
        ]);
    }
}



