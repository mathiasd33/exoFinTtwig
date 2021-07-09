<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    //fontction qui permet de faire des recherches a partir de caractères contenue dans la recherche
    //la variable $term est le résultat
    public function searchByTerm($term)
    {
        //j' utilise la methode queryBuilder pour créer une requete sql en php
        //on met un alias qui correspond a l endroit de la recherche
        $queryBuilder = $this->createQueryBuilder('article');

        //création de la requete vers la bdd
        $query = $queryBuilder

            //requete pour recuperer les attributs
            ->select('article')

            //parametre de requete
            ->where('article.content Like :term')

            //parametre de sécurité afin que l utilisateur ne tape pas de requete sql dans l input
            ->setParameter('term','%'.$term.'%')

            //transformation en requete sql
            ->getQuery();

        //retourne le resultat de la requete
        return $query->getResult();





    }
}
