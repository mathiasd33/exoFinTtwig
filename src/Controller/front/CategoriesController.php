<?php

namespace App\Controller\front;

use App\Repository\CatagoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesController extends AbstractController
{


    /**
     * @Route ("/front/categories", name="categories")
     */

    public function categories_list(CatagoryRepository $catagoryRepository)
    {
        $categories = $catagoryRepository->findAll();
       return $this->render('front/categories_list.html.twig',[
         'categories' =>$categories
       ]);
    }



    /**
     * @Route ("/front/categorie/{id}", name="categorie_show")
     */

    public function categorie_show($id, CatagoryRepository $catagoryRepository)
    {
        $categorie = $catagoryRepository->find($id);
        if (is_null($categorie)){
            throw new NotFoundHttpException();
        }
        return $this->render("front/categorie_show.html.twig", [
           'categorie' => $categorie
        ]);
    }
}



