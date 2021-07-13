<?php


namespace App\Controller\front;


use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class TagController extends AbstractController
{
    /**
     * @Route ("/front/tags", name="tags")
     */
    public function tagList(TagRepository $tagRepository){

        $tags = $tagRepository->findAll();

        return $this->render('front/tag_list.html.twig',[
           'tags'=> $tags
        ]);

    }

    /**
     * @Route ("front/tag/{id}", name="tag_show")
     *
     */
    public function tagShow($id, TagRepository $tagRepository){
        $tag = $tagRepository->find($id);

        if (is_null($tag)){
            throw new NotFoundHttpException();
        }
        return $this->render('front/tag_show.html.twig',[
            'tag'=>$tag
        ]);
    }

}