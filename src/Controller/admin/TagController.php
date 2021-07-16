<?php


namespace App\Controller\admin;


use App\Entity\Tag;
use App\Form\TagType;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TagController extends AbstractController
{
    /**
     * @Route ("/admin/tags", name="admin_tag_list")
     */
    public function tagList(TagRepository $tagRepository){

        $tags = $tagRepository->findAll();

        return $this->render('admin/tag_list.html.twig',[
           'tags'=> $tags
        ]);

    }

    /**
     * @Route ("/admin/tags/insert",name="admin_tag_insert")
     */
    public function insertTag(Request $request, EntityManagerInterface $entityManager)
    {

        $tag = new Tag();
        //on génère le formulaire en utilisant le gabarit + une instance de l entité Article
        $tagForm = $this->createForm(TagType::class, $tag);

        // on lie le formulaire aux données de POST
        $tagForm->handleRequest($request);

        if ($tagForm->isSubmitted() && $tagForm->isValid()) {
            $entityManager->persist($tag);
            $entityManager->flush();

            return $this->redirectToRoute('admin_tag_list');


        }
        return $this->render('admin/insertTag.html.twig', [
            'tagForm' => $tagForm->createView()
        ]);


//        //création d'un tag
//        $tag = new Tag();
//
//        //setters pour renseigner la valeur des colonnes
//
//        $tag->setTitle('titre tag');
//        $tag->setColor('black');
//
//
//        $entityManager->persist($tag);
//
//        //sauvegarde entité
//        $entityManager->persist($tag);
//
//        //récupération des entitées pour les inserer en bdd
//        $entityManager->flush();



    }

    /**
     * @Route ("/admin/tag/update/{id}",name="admin_tag_update")
     */
    public function updateTag ($id, TagRepository $tagRepository, EntityManagerInterface $entityManager, Request $request)
    {

        $tag = $tagRepository->find($id);
        //on génère le formulaire en utilisant le gabarit + une instance de l entité Article
        $tagForm = $this->createForm(TagType::class, $tag);

        // on lie le formulaire aux données de POST
        $tagForm->handleRequest($request);

        if ($tagForm->isSubmitted() && $tagForm->isValid()) {
            $entityManager->persist($tag);
            $entityManager->flush();

            return $this->redirectToRoute('admin_tag_list');


        }
        return $this->render('admin/insertTag.html.twig', [
            'tagForm' => $tagForm->createView()
        ]);


//        $tag = $tagRepository->find($id);
//        if ($tag)
//        {
//            $tag->setTitle("nouveau titre");
//            $tag->setColor('purple');
//            $entityManager->persist($tag);
//            $entityManager->flush();
//
//        }
        //return $this->redirectToRoute('admin_tag_list');
    }


    /**
     * @Route ("/admin/tags/delete/{id}",name="admin_tag_delete")
     */
    public function deleteTag($id, TagRepository $tagRepository, EntityManagerInterface $entityManager)
    {

        $tag = $tagRepository->find($id);
        $entityManager->remove($tag);
        $entityManager->flush();

        return $this->redirectToRoute('admin_tag_list');
    }

}