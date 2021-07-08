<?php


namespace App\Controller;


use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class tagController extends AbstractController
{
    /**
     * @Route ("/tags", name="tags")
     */
    public function tagList(TagRepository $tagRepository){

        $tags = $tagRepository->findAll();

        return $this->render('tagList.html.twig',[
           'tags'=> $tags
        ]);

    }

    /**
     * @Route ("/tag/{id}", name="tagShow")
     *
     */
    public function tagShow($id, TagRepository $tagRepository){
        $tag = $tagRepository->find($id);

        if (is_null($tag)){
            throw new NotFoundHttpException();
        }
        return $this->render('tagShow.html.twig',[
            'tag'=>$tag
        ]);
    }

}